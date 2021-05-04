<?php

namespace Postbox\LaravelInstaller\Controllers;

use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

use Postbox\LaravelInstaller\Requests\StoreAppData;
use Postbox\LaravelInstaller\Requests\StoreDBData;

use App\Http\Controllers\Controller;

use Artisan;

class LaravelInstaller extends Controller
{
    // controller code
    protected $envPath;
    protected $data;
    protected $sessiondb;
    protected $sessionapp;
    protecTed $processFlags = ['app','db','verified'];
    protecTed $sessionFlags = [];
    protected $serverVars;
    protected $currentUrl;
    protected $baseUrl;
    protected $envKey;
    protected $urlSegments;
    protected $loadedExtensions;
    protected $loadedExtensionCodes;
    protected $requiredExtensionCodes;
    protected $requiredExtensions = ['BCMath','Ctype','JSON','Mbstring','OpenSSL','PDO','Tokenizer','XML'];

    /**
     * Constructor initialized.
     */
    public function __construct()
    {
        // Constructor function
        $this->envPath = base_path('.env');
    }

    private function _updateEnv($env, $val) {
        // environment variable is not present and needs to be created - create it and return
        if(gettype(getenv($env)) == 'boolean' && getenv($env) == false) {
            file_put_contents($this->envPath, PHP_EOL . $env . '=' . '"'.$val.'"', FILE_APPEND);
            return;
        }

        // environment variable is present and needs to be updated
        if(preg_match('/\\s/',env($env))) {
            file_put_contents($this->envPath, str_replace(
                $env.'="'.env($env).'"', preg_match('/\\s/',$val)?$env . '=' .'"'.$val.'"':$env . '=' . $val, file_get_contents($this->envPath)
            ));
        } elseif(preg_match('/\\s/',$val)) {
            file_put_contents($this->envPath, str_replace(
                $env.'='.env($env), $env . '=' . '"'.$val.'"', file_get_contents($this->envPath)
            ));
        } else {
            file_put_contents($this->envPath, str_replace(
                $env . '=' . env($env), $env . '=' . $val , file_get_contents($this->envPath)
            ));
        }
        return;
    }

    private function _isDirAccessible($path) {
        if($path == 'storage') {
            $fstream = @fopen(base_path('/'.$path.'/logs/laravel-'.date('Y-m-d').'.log'),'a');
            if(!is_resource($fstream)) {
                return false;
            }
            return true;
        }
        return false;
    }

    private function _isDirWritable($path) {
        if(!is_writable(base_path($path))) {
            return false;
        }
        return true;
    }

    // System requirements page
    public function systemRequirements() {
        $this->loadedExtensions = get_loaded_extensions();
        $this->loadedExtensionCodes = array_map('strtolower',$this->loadedExtensions);
        $this->requiredExtensionCodes = array_map('strtolower',$this->requiredExtensions);

        $this->data['formUrl'] = url('/install/save/requirements');
        $this->data['title'] = 'System Requirements';
        $this->data['progress'] = 0;
        $this->data['btnState'] = count(array_diff($this->requiredExtensionCodes,$this->loadedExtensionCodes))>0?'disabled':((!$this->_isDirAccessible('storage') || !$this->_isDirWritable('bootstrap/cache'))?'disabled':'');

        $this->data['specs'][] = [
            'label'             =>  'PHP Version -',
            'value'             =>  phpversion(),
            'bulletClass'       =>  (version_compare(phpversion(),'7.1.3') >= 1)?'fa-check':'fa-times',
            'bulletColorClass'  =>  (version_compare(phpversion(),'7.1.3') >= 1)?'btn-success':'btn-danger'

        ];
        $this->data['specs'][] = [
            'label'             =>  'Storage folder permissions',
            'value'             =>  '',
            'bulletClass'       =>  $this->_isDirAccessible('storage')?'fa-check':'fa-times',
            'bulletColorClass'  =>  $this->_isDirAccessible('storage')?'btn-success':'btn-danger'
        ];
        $this->data['specs'][] = [
            'label'             =>  'Bootstrap folder permissions',
            'value'             =>  '',
            'bulletClass'       =>  $this->_isDirWritable('bootstrap/cache')?'fa-check':'fa-times',
            'bulletColorClass'  =>  $this->_isDirWritable('bootstrap/cache')?'btn-success':'btn-danger'
        ];

        foreach($this->requiredExtensions as $idx=>$extension) {
            $this->data['specs'][] = [
                'label'         =>  $extension,
                'value'         =>  '',
                'bulletClass'   =>  in_array($this->requiredExtensionCodes[$idx],$this->loadedExtensionCodes)?'fa-check':'fa-times',
                'bulletColorClass'  =>  in_array($this->requiredExtensionCodes[$idx],$this->loadedExtensionCodes)?'btn-success':'btn-danger',
            ];
        }

        return view('laravelinstaller::requirements',$this->data);
    }

    // Application details form
    public function appDetails()
    {
        if(in_array('requirements',session('process.flags'))) {
            //Your code goes here
            $this->data['app'] = session('process.app');
            $this->data['title'] = 'Application details';
            $this->data['prevUrl'] = url('/install');
            $this->data['formUrl'] = url('/install/save/application');
            $this->data['progress'] = 25;
            $this->data['btnState'] = '';
            return view('laravelinstaller::application', $this->data);
        }
    }

    // Database details form
    public function dbDetails()
    {
        if(in_array('app',session('process.flags')) && in_array('requirements',session('process.flags'))) {
            //Your code goes here
            $this->data['db'] = session('process.db');
            $this->data['title'] = 'Database details';
            $this->data['prevUrl'] = url('/install/application');
            $this->data['formUrl'] = url('/install/save/database');
            $this->data['progress'] = 50;
            $this->data['btnState'] = '';

            return view('laravelinstaller::database', $this->data);
        } else {
            return redirect('/install/application');
        }
    }

    // Verify submitted details
    public function verifyDetails()
    {
        if(in_array('app',session('process.flags')) && in_array('requirements',session('process.flags')) && in_array('db',session('process.flags'))) {
            $this->data['title'] = 'Verify details';
            $this->data['appData'] = session('process.app');
            $this->data['dbData'] = session('process.db');
            $this->data['prevUrl'] = url('/install/database');
            $this->data['formUrl'] = url('/install/save/verified');
            $this->data['progress'] = 75;
            $this->data['btnState'] = '';

            return view('laravelinstaller::verifydetails', $this->data);
        } else {
            return redirect('/install/database');
        }
    }

    // process installation
    public function processDetails() {
        $this->sessionFlags = is_array(session('process.flags'))?session('process.flags'):[];
        $this->data['state'] = array_diff($this->processFlags,$this->sessionFlags);
        if(empty($this->data['state'])) {
            $this->data['title'] = 'Installation in progress...';
            $this->data['titleComplete'] = 'Installation completed successfully!';
            $this->data['titleIncomplete'] = 'Installation failed!';
            $this->data['formUrl'] = 'javascript:;';
            $this->data['progress'] = 100;
            $this->data['btnState'] = 'disabled';

            return view('laravelinstaller::installation', $this->data);
        } else {
            return redirect('/install');
        }
    }

    // Store requirements in the session or just redirect to application form page
    public function storeRequirements(Request $request) {
        $this->sessionFlags = $request->session()->get('process.flags');
        $this->sessionFlags = is_array($this->sessionFlags)?$this->sessionFlags:[];
        array_push($this->sessionFlags,'requirements');
        $request->session()->put('process.flags',$this->sessionFlags);
        return redirect('/install/application');
    }

    // Store app data in a session
    public function storeAppDetails(StoreAppData $request) {
        $this->sessionFlags = $request->session()->get('process.flags');
        array_push($this->sessionFlags,'app');
        $request->session()->put('process.flags',$this->sessionFlags);
        $request->session()->put('process.app',$request->all());
        return redirect('/install/database');
    }

    // Store db details in a session and update to env file
    public function storeDBDetails(StoreDBData $request) {
        $this->sessionFlags = $request->session()->get('process.flags');
        array_push($this->sessionFlags,'db');
        $request->session()->put('process.flags',$this->sessionFlags);

        try {
            config(['database.connections.'. $request->connection .'.host' => $request->host]);
            config(['database.connections.'. $request->connection .'.database' => $request->database]);
            config(['database.connections.'. $request->connection .'.username' => $request->user]);
            config(['database.connections.'. $request->connection .'.password' => $request->password]);
            DB::connection($request->connection)->getPdo();
            $request->session()->put('process.db',$request->all());
            return redirect('/install/verify-details');
        } catch(\Exception $e) {
            $request->session()->flash('message', 'Cannot establish database connection');
            return redirect('/install/database');
        }
    }

    // store verified data in session and proceed
    public function storeVerifiedData(Request $request) {
        $this->sessionFlags = $request->session()->get('process.flags');
        array_push($this->sessionFlags,'verified');
        $request->session()->put('process.flags',$this->sessionFlags);

        return redirect('/install/process-details');
    }

    // update environment variables after installation is done
    public function updateEnvironment() {
        try {
            $this->sessiondb = session('process.db');
            $this->sessionapp = session('process.app');

            // application env file updates
            $this->_updateEnv('APP_DESCRIPTION',$this->sessionapp['description']);
            $this->_updateEnv('APP_KEYWORDS',$this->sessionapp['keywords']);

            // database env file updates
            $this->_updateEnv('DB_CONNECTION',$this->sessiondb['connection']);
            $this->_updateEnv('DB_HOST',$this->sessiondb['host']);
            $this->_updateEnv('DB_PORT',$this->sessiondb['port']);
            $this->_updateEnv('DB_DATABASE',$this->sessiondb['database']);
            $this->_updateEnv('DB_USERNAME',$this->sessiondb['user']);
            $this->_updateEnv('DB_PASSWORD',$this->sessiondb['password']);

            return response()->json(['res' => true]);
        } catch(\Exception $e) {
            return response()->json(['res' => false,'message'=>$e->getMessage()],500);
        }
    }

    // Run database migrations and seeds
    public function runMigrations() {
        try {
            Artisan::call('migrate:fresh');
            Artisan::call('db:seed');
            return response()->json(['res' => true]);
        } catch(\Exception $e) {
            return response()->json(['res' => false,'message'=>$e->getMessage()],500);
        }
    }

    // create storage folder link
    public function createStorageLink() {
        $this->sessionapp = session('process.app');
        try {
            Artisan::call('storage:link');
            $this->_updateEnv('APP_NAME',$this->sessionapp['title']); // app name is updated last to avoid csrf token mismatch
            $this->_updateEnv('APP_INSTALLED',true);
            return response()->json(['res' => true]);
        } catch(\Exception $e) {
            return response()->json(['res' => false,'message'=>$e->getMessage()],500);
        }
    }
}
