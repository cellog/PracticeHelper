<?php
include __DIR__ . '/autoload.php';

// format {"client":"your-client-id","token":"your api token"}
$config = json_decode(file_get_contents(__DIR__ . '/mylocaltest.json'), 1);

$tokenmanager = new Chiara\AuthManager\File(__DIR__ . '/localtokens.json',
                                            __DIR__ . '/mylocaltest.json',
                                            __DIR__ . '/map.json',
                                            true);
Chiara\AuthManager::setTokenManager($tokenmanager);
Chiara\AuthManager::attemptPasswordLogin();
//Chiara\AuthManager::attemptServerLogin('http://localhost' . $_SERVER['PHP_SELF'], isset($_GET['logout']),
//                                       isset($_GET['code']) ? $_GET['code'] : false);

// This example shows how helper classes can be generated for a specific subset of workspaces
// in 3 lines of code (the 4th is just for informational purposes)
$myorganizations = Chiara\PodioOrganization::mine();
foreach ($myorganizations['unledu']->workspaces->matching('^Practicing: Greg Beaver') as $space) {
    $ret = $space->generateClasses(__DIR__ . '/PracticeHelper/Model', 'PracticeHelper\Model', false, null, 'PracticeHelper/Model/Base');
    echo $space, " processed<br>\n";
}