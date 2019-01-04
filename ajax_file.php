<?php
include_once "tadtools_header.php";

include_once $GLOBALS['xoops']->path('/modules/system/include/functions.php');
$op       = system_CleanVars($_REQUEST, 'op', '', 'string');
$mod_name = system_CleanVars($_REQUEST, 'mod_name', '', 'string');
$files_sn = system_CleanVars($_REQUEST, 'files_sn', '', 'int');

if ($xoopsUser) {
    if (!is_object($xoopsModule)) {
        $modhandler  = xoops_gethandler('module');
        $xoopsModule = $modhandler->getByDirname($mod_name);
    }

    $mod_id  = $xoopsModule->mid();
    $isAdmin = $xoopsUser->isAdmin($module_id);
    if ($isAdmin) {
        switch ($op) {
            case 'remove_file':
                include_once XOOPS_ROOT_PATH . "/modules/tadtools/TadUpFiles.php";
                $TadUpFiles = new TadUpFiles($mod_name);
                if ($TadUpFiles->del_files($files_sn)) {
                    echo '1';
                }
                break;

            default:
                # code...
                break;
        }
    }
}
