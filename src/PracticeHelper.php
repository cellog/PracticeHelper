<?php
class PracticeHelper
{
    private $org_id = 136384;
    private $tokenmanager;
    protected $key;
    function __construct($nologin = false)
    {
        $user = explode('/', $_SERVER['DOCUMENT_ROOT']);
        $user = $user[2];
        $mapfile = __DIR__ . '/pmap.json';
        if (file_exists('/home/' . $user . '/practice.json')) {
            $clientfile = '/home/' . $user . '/practice.json';
            $mapfile = '/home/' . $user . '/pmap.json';
        } else {
            // local debugging
            $clientfile = __DIR__ . '/practice.json';
        }
        if (file_exists('/home/' . $user . '/practicetokens.json')) {
            $tokenfile = '/home/' . $user . '/practicetokens.json';
        } else {
            // local debugging
            $tokenfile = __DIR__ . '/practicetokens.json';
        }
        $this->tokenmanager = new Chiara\AuthManager\File($tokenfile, $clientfile, $mapfile, true);
        Chiara\AuthManager::setAuthMode(Chiara\AuthManager::USER);
        Chiara\AuthManager::setTokenManager($this->tokenmanager);
        if (!$nologin) {
            if (!isset($_GET['logout']) && (Podio::$oauth->access_token || $this->authenticate())) {
                $this->key = Podio::$oauth->access_token;
            } else {
                $this->login();
            }
        }
        if (isset($_SESSION) && !isset($_SESSION['practicing'])) {
            $_SESSION['practicing'] = array();
        }
    }

    protected function getPracticeThing($thing, $checkform = true)
    {
        if ($checkform && isset($_GET) && isset($_GET[$thing])) {
            $_SESSION['practicing'][$thing] = filter_var($_GET[$thing], FILTER_SANITIZE_NUMBER_INT);
        }
        if (isset($_SESSION) && isset($_SESSION['practicing']) && isset($_SESSION['practicing'][$thing])) {
            return $_SESSION['practicing'][$thing];
        }
        return null;
    }

    function myPracticeWorkspace()
    {
        $id = $this->getPracticeThing('workspace');
        $this->determineAppIds($id);
        return $id;
    }

    protected function determineAppIds($id)
    {
        if (!$id || $this->getPracticeThing('app', false)) {
            return;
        }
        $workspace = new Chiara\PodioWorkspace($id);
        foreach ($workspace->apps as $potential) {
            if ($potential->config['name'] == 'Practicing') {
                $_SESSION['practicing']['app'] = $potential->id;
            }
            if ($potential->config['name'] == 'Rep') {
                $_SESSION['practicing']['rep'] = $potential->id;
            }
            if ($potential->config['name'] == 'Etudes') {
                $_SESSION['practicing']['etudes'] = $potential->id;
            }
            if ($potential->config['name'] == 'Technique') {
                $_SESSION['practicing']['technique'] = $potential->id;
            }
        }
    }

    function myPracticeApp()
    {
        $id = $this->getPracticeThing('app', false);
        if ($id) {
            return new Chiara\PodioApp($id);
        }
    }

    function myRepApp()
    {
        $id = $this->getPracticeThing('rep', false);
        if ($id) {
            return new Chiara\PodioApp($id, false);
        }
    }

    function myEtudesApp()
    {
        $id = $this->getPracticeThing('etudes', false);
        if ($id) {
            return new Chiara\PodioApp($id, false);
        }
    }

    function myTechniqueApp()
    {
        $id = $this->getPracticeThing('technique', false);
        if ($id) {
            return new Chiara\PodioApp($id, false);
        }
    }

    function myPracticeItem($pid = null)
    {
        $id = $this->getPracticeThing('app', false);
        if ($id) {
            $ret = new PracticeHelper\Model\Practicing($pid);
            $ret->switchModel($id);
            return $ret;
        }
    }

    function myRepItem($rid = null)
    {
        $id = $this->getPracticeThing('rep', false);
        if ($id) {
            $ret = new PracticeHelper\Model\Rep($rid);
            $ret->switchModel($id);
            return $ret;
        }
    }

    function myEtudesItem($eid = null)
    {
        $id = $this->getPracticeThing('etudes', false);
        if ($id) {
            $ret = new PracticeHelper\Model\Etudes($eid);
            $ret->switchModel($id);
            return $ret;
        }
    }

    function myTechniqueItem($tid = null)
    {
        $id = $this->getPracticeThing('technique', false);
        if ($id) {
            $ret = new PracticeHelper\Model\Technique($tid);
            $ret->switchModel($id);
            return $ret;
        }
    }

    function login()
    {
        $clientinfo = $this->tokenmanager->getAPIClient();
        header('Location: https://podio.com/oauth/authorize?client_id=' . $clientinfo['client'] . '&redirect_uri=' .
               urlencode('http://www.chiaraquartet.net/PracticeHelper/web/index.php'));
    }

    function authenticate()
    {
        if (isset($_GET['code'])) {
            Podio::authenticate('authorization_code', array('code' => $_GET['code'],
                                                            'redirect_uri' => 'http://www.chiaraquartet.net/PracticeHelper/web/index.php'));
            return true;
        }
        return false;
    }

    function path()
    {
        return '/PracticeHelper/web/index.php';
    }

    function linkTo($thing)
    {
        return '<a href="' . $thing->link($this) . '">' . $thing->name() . '</a>';
    }

    function route()
    {
        $workspace = $this->myPracticeWorkspace();
        // todo: set up the practice/rep/technique/etudes app inside myPracticeApp on first retrieval
        if (!$workspace) {
            $this->me = Chiara\PodioContact::me();
            foreach ($this->me->myorganizations as $org)
            {
                if ($org->id == 136384) {
                    return new PracticeHelper\Page\ChooseWorkspace($org);
                }
            }
        }
        $app = $this->myPracticeApp();
        $rep = $this->myRepApp();
        $technique = $this->myTechniqueApp();
        $etudes = $this->myEtudesApp();
        // ok, we are ready to go.
        if (isset($_GET['stop'])) {
            // insert new practice journal entry
            var_dump($_SESSION['practicing']);
            $total = time() - $_SESSION['practicing']['starttime'];
            $rep = $_SESSION['practicing']['practiced'];
            switch ($rep[0]) {
                case 'rep' :
                    $piece = $this->myRepItem($rep[1]);
                    break;
                case 'technique' :
                    $piece = $this->myTechniqueItem($rep[1]);
                    break;
                case 'etudes' :
                    $piece = $this->myEtudeItem($rep[1]);
                    break;
            }
            return "<h1>Total time: $total</h1>" .
                   "<h1>Piece: " . $rep[0] . ' ' . $piece->title . '</h1>';
        }
        if (isset($_GET['rep']) || isset($_GET['etudes']) || isset($_GET['technique'])) {
            return new PracticeHelper\Templates\BigButton('stop', 'Finish practicing', 'btn-danger');
            $_SESSION['practicing']['starttime'] = time();
            if (isset($_GET['rep'])) {
                $_SESSION['practicing']['practiced'] = array('rep', filter_var($_GET['rep'], FILTER_SANITIZE_NUMBER_INT));
            }
            if (isset($_GET['technique'])) {
                $_SESSION['practicing']['practiced'] = array('technique', filter_var($_GET['technique'], FILTER_SANITIZE_NUMBER_INT));
            }
            if (isset($_GET['etudes'])) {
                $_SESSION['practicing']['practiced'] = array('etudes', filter_var($_GET['etudes'], FILTER_SANITIZE_NUMBER_INT));
            }
        }
        if (isset($_GET['go'])) {
            return new PracticeHelper\Page\ChooseRep($rep, $etudes, $technique);
        }
        return new PracticeHelper\Templates\BigButton();
    }

    function __toString()
    {
        try {
            return (string) $this->route();
        } catch (\Exception $e) {
            echo '<pre>',$e;
        }
    }
}
