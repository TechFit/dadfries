<?php

namespace common\components;

use Yii;
use common\models\User;
use common\models\update\UpdateHistory;
use yii\helpers\FileHelper;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;


class UpdateSystemException extends \Exception {

}

class Updater extends Component
{

  public $params;
  public $fsServer = 'http://127.0.0.1:3999/yii/console';
  private $errors = [];

  private $paths = [
    'project' => null,
    'base' => null,
    'zipFile' => null,
    'packageFile' => null,
    'extract' => null,
    'backup' => null,
    'logs' => null,
    'packages' => null,
    'update' => null,
  ];

  private $actualFolder;
  private $archivePass = "1111-2222-3333-4444";
  private $action;
  private $log = [];
  private $result = false;
  private $updateConfig;
  private $history;

  private $licenseKey;

  /**
   * Set paths for updater
   *
   * @param array $params
   *
   */
  public function init()
  {
    parent::init();

    try
    {
      foreach(array_keys($this->paths) as $k)
      {
        $key = $k . '-path';
        if(isset($this->params[$key]))
        {
          $this->setPath($k, $this->params[$key]);
        }
        else if($k == 'project')
        {
          $this->setPath($k, Yii::getAlias('@app/..'));
        }
        else if($k == 'base' && $this->paths['project'] != null)
        {
          $path = $this->paths['project'] . DIRECTORY_SEPARATOR . "updates";
          FileHelper::createDirectory($path);
          $this->setPath($k, $path);
        }
        else if($this->paths['base'] != null && in_array($k,['extract', 'backup', 'logs', 'packages']))
        {
          $this->setPath($k, $this->paths['base'] . DIRECTORY_SEPARATOR . $k);
        }
      }

      $this->checkFolders();
    }
    catch (\Exception $e)
    {
      $this->processLog($e->getMessage(),'error');
      return false;
    }
    return true;
  }

  /**
  * Check and create folders if don't exist
  */
  private function checkFolders()
  {
    foreach($this->paths as $k => $path)
    {
      if($path != null && !file_exists($path))
      {
        if(!FileHelper::createDirectory($path))
        {
          throw new UpdateSystemException(Yii::t('app','Не вдалося створити директорію {path} для ключа {key}', ['path' => $path, 'key' => $k]));
        }
      }
    }
  }

  /**
  * @param string $key
  * @param string $path
  */
  public function setPath($key, $path)
  {
    $this->paths[$key] = $path;
  }

  /**
  * @param string $key
  */
  private function getPath($key)
  {
    if(!isset($this->paths[$key]))
    {
      throw new UpdateSystemException("Path for key $key is not set");
    }

    $path = $this->paths[$key];
    if(!file_exists($path))
    {
      if(!FileHelper::createDirectory($path))
      {
        throw new UpdateSystemException("Cannot get path for key $key: $path");
      }
    }
    return $path;
  }

  /**
  * @param string $key
  */
  private function getFilePath($key)
  {
    $path = $this->paths[$key];
    if(!file_exists($path))
    {
        throw new UpdateSystemException("Cannot get path for key $key: $path");
    }
    return $path;
  }


  /**
  * @param string $key
  */
  private function getActualPath($key)
  {
    $path = $this->getPath($key);
    $path .= DIRECTORY_SEPARATOR . $this->getActualFolder();
    if(!file_exists($path))
    {
      if(!FileHelper::createDirectory($path))
      {
        throw new UpdateSystemException("Cannot get actual path for key $key: $path");
      }
    }
    return $path;
  }

  private function getActualFolder()
  {
    if(!$this->actualFolder)
    {
      $this->actualFolder = "_" . date("YmdHis");
    }
    return $this->actualFolder;
  }

  /**
   * Get migrations count in this update
   * @return int count
   */
  public function getMigrationsCount()
  {
    $migrationsPath = $this->getActualPath('extract') . DIRECTORY_SEPARATOR . 'migrations';
    if(file_exists($migrationsPath))
    {
      $files = glob($migrationsPath.DIRECTORY_SEPARATOR.'m*.php');
      return count($files);
    }
    else return 0;
  }

  /*public function getHistory()
  {
    $dir = $this->getPath('logs');
    if(!file_exists($dir))
    {
      return [];
    }
    $dirtree = self::dirtree($dir);
    $res = [];
    $lastSuccessDir = "";
    ksort($dirtree);
    foreach($dirtree as $dir => $files)
    {
      if(!is_array($files)) $files = [$files];
      foreach($files as $f)
      {
          $filename = explode(".", $f)[0];
          $fileInfo = explode("_", $filename);
          if(count($fileInfo) == 5)
          {
            list($tmp, $time, $dir, $action, $result) = $fileInfo;
          }
          else if(count($fileInfo) == 6)
          {
            list($tmp, $time, $dir, $action, $result, $userId) = $fileInfo;
          }

          $username = "";
          if(isset($userId))
          {
            $user = User::findOne($userId);
            if($user)
            {
              $username = $user->name;
            }
          }

          $res[] = [
            'id' => $f,
            'date' => $time,
            'dir' => $dir,
            'success' => $result,
            'action' => $action,
            'filename' => $filename,
            'username' => $username
          ];
      }
    }

    return $res;
  }
*/
  /**
   * Save list of directories that were created during updating
   *
   * @param array $dirs array of relative paths to directories
   */
  private function savedirs($dirs)
  {
    if(is_array($dirs) && count($dirs) > 0)
    {
      try
      {
        $filepath = $this->getActualPath('extract') . DIRECTORY_SEPARATOR . $this->getActualFolder() . ".csv";
        $file = fopen($filepath,"w");
        foreach ($dirs as $dir)
        {
          fputcsv($file, [$dir]);
        }
      }
      catch(\Exception $e)
      {
        $this->processLog("Cannot create file: $filepath, " . $e->getMessage(), "error");
      }
      finally
      {
        fclose($file);
      }
    }
  }

  /**
   * Get list of directories that were created during specific update
   *
   * @return array array of directories
   */
  private function readdirs()
  {
    $result = [];
    $filepath = $this->getActualPath('extract') . DIRECTORY_SEPARATOR . $this->getActualFolder() . ".csv";
    if(file_exists($filepath))
    {
      try
      {
        $file = fopen($filepath,"r");

        while(! feof($file))
        {
          $res = fgetcsv($file);
          $result[] = $res[0];
        }
      }
      catch (\Exception $e)
      {
        $this->processLog("Cannot read file: $filepath, " . $e->getMessage(), "error");
      }
      finally
      {
        fclose($file);
      }
    }
    else
    {
      $this->processLog("There were no directories created for this update", "info");
    }

    return $result;
  }

  public function getUpdateId()
  {

    return $this->actualFolder . "_" . $this->action;
  }

  public function getAction()
  {
    return $this->action;
  }

  public function getResult()
  {
    return $this->result;
  }

  /**
   * Set folder name that will be used for extracting archive and for project backup
   *
   * @param string $folderName
   */
  public function setActualFolder($folder)
  {
    $this->actualFolder = $folder;
  }

  /**
   * Creates a tree-structured array of directories and files from a given root folder.
   *
   * Gleaned from: http://stackoverflow.com/questions/952263/deep-recursive-array-of-directory-structure-in-php
   *
   * @param string $dir
   * @param string $regex
   * @param boolean $ignoreEmpty Do not add empty directories to the tree
   * @return array
   */
  public static function dirtree($dir, $regex='', $ignoreEmpty=false)
  {
      if (!$dir instanceof \DirectoryIterator) {
          $dir = new \DirectoryIterator((string)$dir);
      }
      $dirs  = array();
      $files = array();
      foreach ($dir as $node) {
          if ($node->isDir() && !$node->isDot()) {
              $tree = self::dirtree($node->getPathname(), $regex, $ignoreEmpty);

              if (!$ignoreEmpty || count($tree)) {
                  $dirs[$node->getFilename()] = $tree;
              }
          } elseif ($node->isFile()) {
              $name = $node->getFilename();
              if ('' == $regex || preg_match($regex, $name)) {
                  $files[] = $name;
              }
          }
      }
      asort($dirs);
      sort($files);
      return array_merge($dirs, $files);
  }

  /**
  * Main function of the class. Make all the required operations for updating the system:
  * - unzip file
  * - make project backup
  * - copy files from extracted archive to project
  * - revert if something goes wrong
  * @return boolean result
  */
  public function update()
  {
    $this->result = false;
    try
    {
      $this->prepareUpdate();
      $this->moveDirsExternal();
      $this->history->status = 1;
      $this->history->save();
      $this->result = true;
      return true;
    }
    catch(\Exception $e)
    {
      $this->processLog($e->getMessage(),'error');
      return false;
    }
    $this->result = true;
    return true;
  }

  /**
  * Unzip archive
  */
  public function prepareUpdate()
  {
      $this->action = "update";
      $this->processLog("Unzipping archive", "info");
      $this->processArchive();
  }

  public function moveDirsExternal()
  {
      try {
          $client = new Client([
              'transport' => 'yii\httpclient\CurlTransport'
          ]);
          $content = '{"command": "update/move-dirs ' . $this->getActualFolder() . '"}';
          $response = $client->createRequest()
            ->setMethod('POST')
            ->setUrl($this->fsServer)
            ->addHeaders(['Content-Type' => 'application/json'])
            ->setContent($content)
            ->send();
          $r = $response;
          if ($response->isOk) {
              return true;
          } else {
              $data = (string)$response->getData();
              throw new UpdateSystemException(Yii::t("app","Помилка з'єднання") . ": " . $data);
          }
      } catch (\Exception $e) {
          throw new UpdateSystemException(Yii::t("app","Помилка з'єднання") . ": " . $e->getMessage());
      }
  }

  public function moveDirs()
  {
      $archiveStruct = self::dirtree($this->getActualPath('extract'));

      $this->processLog("Backuping project", "info");
      $this->backupdir($archiveStruct);

      $this->processLog("Updating project", "info");
      $dirsProgress = [];
      $filesProgress = [];
      try
      {
        $this->copydir($archiveStruct, $filesProgress, $dirsProgress);
        if(count($dirsProgress) > 0)
        {
          $this->processLog("New project directories: ");
          foreach($dirsProgress as $d)
          {
            $this->processLog($d);
          }
        }

        $this->savedirs($dirsProgress);
        $this->migrate();
      }
      catch(\Exception $e)
      {
        $this->processLog($e->getMessage(),"error");
        $this->writeLog();
        $this->revert($filesProgress, $dirsProgress);
        return false;
      }
  }

  /**
  * Create update package
  * - generate hash for archive file
  * - create package.json
  * - zip everything
  * @return boolean result
  */
  public function create($params = [])
  {
    $this->result = false;
    try
    {
      $sourcePath = isset($params['update-path']) ? $params['update-path'] : Yii::getAlias('@app/update');
      $name = isset($params['archive-name']) ? $params['archive-name'] : 'update.zip';
      $source = isset($params['source-file']) ? $params['source-file'] : 'project.pat';

      $zip = new \ZipArchive();
      $zipStruct = self::dirtree($sourcePath);
      $sourceFile = $sourcePath . DIRECTORY_SEPARATOR . $source;
      if ($zip->open($sourceFile, (\ZipArchive::CREATE | \ZipArchive::OVERWRITE)) === TRUE)
      {
        $ignore = [$name, $source];
        $this->zipdir($sourcePath, $zipStruct, $zip, $ignore);
      }

      $zip->close();

      if(!file_exists($sourceFile))
      {
        throw new UpdateSystemException("File $sourceFile does not exist");
      }

      $build = UpdateHistory::getNextBuild();

      $jsonStruct = [
        'app_id' => 'kpm',
        'description' => 'Test app',
        'build' => $build,
        'date_issued' => date('Y-m-d'),
        'checksum' => hash_file("sha256", $sourceFile),
        'priority' => 1,
      ];
      $txt = json_encode($jsonStruct);

      $zip = new \ZipArchive();
      $newArchivePath =  $sourcePath . DIRECTORY_SEPARATOR . $name;

      if ($zip->open($newArchivePath, (\ZipArchive::CREATE | \ZipArchive::OVERWRITE)) === TRUE)
      {
          // Add files to the zip file
          //$zip->addFile($sourcePath . DIRECTORY_SEPARATOR . $source, $source);
          //$zip->setEncryptionName($source, ZipArchive::EM_AES_256, $this->archivePass);

          // Add a file new.txt file to zip using the text specified
          $zip->addFromString('package.json', $txt);

          // All files are added, so close the zip file.
          $zip->close();
      }

      $zipCommand = "zip -P " . $this->archivePass . " " . $name . " " . $source;
      exec("cd " . $sourcePath . "\n" . $zipCommand);
    }
    catch(\Exception $e)
    {
      $this->processLog($e->getMessage(),'error');
      return false;
    }
    $this->result = true;
    return true;
  }

  /**
  * Revert updates if something goes wrong
  * @param array $filesProgress - files that already copied, need to restore them from backup
  * @param array $dirsProgress - directories that were created during the progrees, should be deleted
  */
  private function revert($filesProgress, $dirsProgress)
  {
    $this->processLog("Reverting update", "info");
    foreach($filesProgress as $f)
    {
      $projectFile = $this->getPath('project') . $f;
      $backupFile = $this->getActualPath('backup') . $f;
      $this->processLog("Revert: removing file $projectFile", "log");
      if(!unlink($projectFile))
      {
        $this->processLog("Revert: cannot remove file $projectFile", "warning");
      }
      if(file_exists($backupFile))
      {
        $this->processLog("Revert: restoring file $backupFile", "log");
        if(!copy($backupFile, $projectFile))
        {
          $this->processLog("Revert: cannot copy file $backupFile to $projectFile", "warning");
        }
      }
    }
    foreach(array_reverse($dirsProgress) as $dir) // delete dirs in reverse order
    {
      $fullPathDir = $this->getPath('project') . $dir;
      $this->processLog("Revert: Removing directory: $fullPathDir", "log");
      if(!rmdir($fullPathDir))
      {
        $this->processLog("Revert: cannot remove directory: $fullPathDir", "warning");
      }
    }
  }

  public function restoreFiles($id)
  {
      $history = UpdateHistory::findOne($id);
      $this->setActualFolder($history->folder);
      $this->action = 'restore';
      $migrationsCount = $this->getMigrationsCount();
      $this->processLog('Migrations found: ' . $migrationsCount, 'migration');
      if($migrationsCount > 0)
      {
          $this->migrate(false, $migrationsCount);
      }

      $this->processLog("RESTORING SYSTEM: " . $this->getActualFolder(), 'info');

      $archiveStruct = self::dirtree($this->getActualPath('extract'));

      $this->backupdir($archiveStruct,"","_beforerestore");
      $this->cleardir($archiveStruct);

      $backupStruct = self::dirtree($this->getActualPath('backup'));
      $this->restoredir($backupStruct);

      $dirs = $this->readdirs();
      $dirs = array_reverse($dirs);
      foreach($dirs as $dir)
      {
          if(trim($dir) != "")
          {
              $fullPath = $this->getPath('project') . $dir;
              $this->processLog("Removing directory: $dir", "log");
              if(!rmdir($fullPath))
              {
                  $this->processLog("Cannot remove directory: $dir", "error");
              }
          }
      }
  }

  public function remoteRestore($id)
  {
      $client = new Client([
          'transport' => 'yii\httpclient\CurlTransport'
      ]);
      $content = '{"command": "update/restore ' . $id . '"}';
      $response = $client->createRequest()
        ->setMethod('POST')
        ->setUrl($this->fsServer)
        ->addHeaders(['Content-Type' => 'application/json'])
        ->setContent($content)
        ->send();
      $r = $response;
      if ($response->isOk) {
          return true;
      } else {
          $data = (string)$response->getData();
          throw new UpdateSystemException($data);
      }

  }

  /**
  * Restore project state from backup
  */
  public function restore($id)
  {
    $this->result = false;
    try
    {
        $this->remoteRestore($id); // Call restoreFiles remotely
        $history = new UpdateHistory();
        $config = [];
        $config['applied_by'] = Yii::$app->user->id;
        $config['action'] = $this->action;
        $config['status'] = 1;
        $config['build'] = $build;
        $config['folder'] = $this->getActualFolder();
        $config['applied_at'] = time();
        $history->setAttributes($config);
        $history->save();
    }
    catch(\Exception $e)
    {
        $this->processLog($e->getMessage(),'error');
        return false;
    }

    $this->result = true;
    return true;
  }

  public function getLogFile($folder, $action)
  {
    $logPath = $this->getPath('logs') . DIRECTORY_SEPARATOR . $folder . "_" . $action . ".csv";
    $file = $logPath;
    if(!file_exists($file))
    {
      return [];
    }

    $log=[];
    if (($handle = fopen($file, "r")) !== FALSE) {
      while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if($data[0] != 'log')
        {
          $log[] = ['type' => $data[0], 'message' => $data[1]];
        }
      }
      fclose($handle);
    }

    return $log;

  }

  /**
  * Delete all files from project that are in input array
  * @param array $filesArr - which files to remove
  * @param string $innerPath - current inner path inside project directory
  */
  function cleardir($filesArr, $currentInnerPath="")
  {
    foreach($filesArr as $dir => $files)
    {
      if(is_array($files))
      {
        $dirname = $dir;
        $innerPath = $currentInnerPath . DIRECTORY_SEPARATOR . $dirname;
        $this->cleardir($files, $innerPath);
      }
      else
      {
        // Check if file exists in the project
        $currentFile = $this->getPath('project') . $currentInnerPath . DIRECTORY_SEPARATOR . $files;
        if(file_exists($currentFile))
        {
          if(unlink($currentFile))
          {
            $this->processLog("Restore: $currentFile deleted", "log");
          }
          else
          {
            $this->processLog("Restore: cannot delete $currentFile", "log");
          }
        }
        else
        {
          $this->processLog("Restore: $currentFile skipped", "log");
        }
      }
    }
  }

  /**
  * Restore all files from specific backup
  * @param array $filesArr - which files to restore
  * @param string $innerPath - current inner path inside backup/project directory
  */
  function restoredir($filesArr, $currentInnerPath = "")
  {
    foreach($filesArr as $dir => $files)
    {
      if(is_array($files))
      {
        $dirname = $dir;
        $currentPath = $currentInnerPath . DIRECTORY_SEPARATOR . $dir;
        $currentFullPath = $this->getPath('project') . $currentPath;
        if(!file_exists($currentFullPath))
        {
          $this->processLog("Restore: Creating project directory: $currentFullPath", "log");
          if(!FileHelper::createDirectory($currentFullPath, 0777, true))
          {
            throw new UpdateSystemException("Cannot create directory: $currentFullPath");
          }
        }
        $this->restoredir($files, $currentPath);
      }
      else
      {
        $filePath = $currentInnerPath . DIRECTORY_SEPARATOR . $files;
        if(!copy($this->getActualPath('backup') . $filePath, $this->getPath('project') . $filePath))
        {
          throw new UpdateSystemException("Cannot copy file: $filePath from {$this->getActualPath('backup')} to {$this->getPath('project')}");
        }
      }
    }
    return true;
  }

  public function processArchive()
  {
    $result = $this->unzipArchive("zipFile", "extract");
    $this->processLog("Unzipping package", "info");
    if($result)
    {
      try {
        $history = new UpdateHistory();

        $config['applied_by'] = Yii::$app->user->id;
        $config['action'] = $this->action;
        $config['folder'] = $this->getActualFolder();
        $config['build'] = UpdateHistory::getNextBuild();
        $config['applied_at'] = time();

        $history->setAttributes($config);
        if($history->validate() && $history->save())
        {
          $this->history = $history;
          $this->updateConfig = $config;
        }
        else
        {
          $errors = $history->getErrorSummary(true);
          foreach($errors as $error)
          {
            $this->processLog($error, 'error');
          }
        }

      } catch (\Exception $e) {
        throw $e;
      }
    }
  }

  function setPassword($pass)
  {
      $this->archivePass = $pass;
  }

  /**
  * Extract files from archive to destination folder
  */
  function unzipArchive($file, $aliasTo)
  {
    $result = true;
    $zip = new \ZipArchive();
    $zip_status = $zip->open($this->getFilePath($file));

    if ($zip_status === true)
    {
      if($this->archivePass)
      {
        if (!$zip->setPassword($this->archivePass))
        {
          throw new UpdateSystemException("Cannot set password");
        }
      }
      if ($result === true)
      {
          if(!$zip->extractTo($this->getActualPath($aliasTo)))
          {
              $this->addError('key', Yii::t('app', 'Не вдається відкрити архів. Перевірте вірність ключа'));
              throw new UpdateSystemException("Extraction failed (wrong password?)");
          }
      }
      $zip->close();
    }
    else
    {
        throw new UpdateSystemException("Failed opening archive: ". @$zip->getStatusString() . " (code: ". $zip_status .")");
    }
    return $result;
  }

  /**
  * Keep track of application messages
  * @param string $message what to process
  * @param string $messageType message type
  */
  function processLog($message, $messageType = "log")
  {
    $this->log[] = ['type' => $messageType, 'message' => $message];
  }

  function getLog()
  {
    return $this->log;
  }

  function getLastError()
  {
    $error = "";
    foreach(array_reverse($this->log) as $l)
    {
      if($l['type'] == 'error')
      {
        return $l['message'];
      }
    }
  }

  public static function getColor($type)
  {
    $result = 'black';
    switch ($type) {
        case 'error':
            $result = 'red';
            break;
        case 'warning':
            $result = 'yellow';
            break;
        default:
            $result = "black";
    }
    return $result;
  }

  /**
  * Backup project directory
  * @param array $filesArr - which files to backup
  * @param string $innerPath - current inner path inside backup/project directory
  * @param string $dir_suffix - suffix will be added to folder name where backup is located
  */
  function backupdir($filesArr, $currentInnerPath = "", $dir_suffix = "")
  {
    foreach($filesArr as $dir => $files)
    {
      if(is_array($files))
      {
        $dirname = $dir;
        $innerPath = $currentInnerPath . DIRECTORY_SEPARATOR . $dirname;
        $this->backupdir($files, $innerPath, $dir_suffix);
      }
      else
      {
        // Check if file exists in the project
        $currentFile = $this->getPath('project') . $currentInnerPath . DIRECTORY_SEPARATOR . $files;
        if(file_exists($currentFile))
        {
          $destFolder = $this->getActualPath('backup') . $dir_suffix . $currentInnerPath;
          if(!file_exists($destFolder))
          {
            $this->processLog("Backup: Creating destination folder: $destFolder", "log");
            if(!FileHelper::createDirectory($destFolder, 0777, true))
            {
              throw new UpdateSystemException("Cannot create directory: $destFolder");
            }
          }
          $this->processLog("Backup: $currentFile copying", "log");
          if(!copy($currentFile, $destFolder . DIRECTORY_SEPARATOR . $files))
          {
            $this->processLog("Backup: cannot copy $currentFile to " . $destFolder . DIRECTORY_SEPARATOR . $files, "warning");
          }
        }
        else
        {
          $this->processLog("Backup: $currentFile skipped", "log");
        }
      }
    }
  }

  /**
  * Zip project directory
  * @param array $filesArr - which files to zip
  * @param string $zipName - final archive name
  * @param string $projectFileName - inner arhive name
  */
  function zipdir($sourcePath, $filesArr, $zip, $ignore = [], $currentInnerPath = "")
  {
    foreach($filesArr as $dir => $files)
    {
      if(is_array($files))
      {
        $dirname = $dir;
        $innerPath = $currentInnerPath . DIRECTORY_SEPARATOR . $dirname;
        //echo "Adding dir: $innerPath\n";
        //$zip->addEmptyDir($innerPath);
        $this->zipdir($sourcePath, $files, $zip, $ignore, $innerPath);
      }
      else
      {
        if(in_array($files, $ignore))
        {
          continue;
        }
        // Check if file exists in the project
        $relativeFile = $currentInnerPath . DIRECTORY_SEPARATOR . $files;
        $currentFile = $sourcePath . $relativeFile;
        if(file_exists($currentFile) && is_file($currentFile))
        {
          $zip->addFile($currentFile, $relativeFile);
        }
      }
    }
  }

  /**
  * Copy files to project directory from extracted archive
  * @param array $filesArr - which files to copy
  * @param array $fileslog - files that were copied
  * @param array dirslog - directories that are create during copying
  * @param string $currentInnerPath - current inner path inside backup/project directory
  */
  function copydir($filesArr, &$fileslog, &$dirslog, $currentInnerPath = "")
  {
    foreach($filesArr as $dir => $files)
    {
      if(is_array($files))
      {
        $dirname = $dir;
        $currentPath = $currentInnerPath . DIRECTORY_SEPARATOR . $dir;
        $currentFullPath = $this->getPath('project') . $currentPath;
        if(!file_exists($currentFullPath))
        {
          $this->processLog("Update: Creating project directory: $currentFullPath", "log");
          if(!FileHelper::createDirectory($currentFullPath, 0777, true))
          {
            throw new UpdateSystemException("Cannot create directory: $currentFullPath");
          }
          $dirslog[] = $currentPath;
        }
        $this->copydir($files, $fileslog, $dirslog, $currentPath);
      }
      else
      {
        $filePath = $currentInnerPath . DIRECTORY_SEPARATOR . $files;
        $result = copy($this->getActualPath('extract') . $filePath, $this->getPath('project') . $filePath);
        $this->processLog("Update: Copying file: $filePath. Result: $result", "log");
        if(!$result)
        {
          throw new UpdateSystemException("Cannot copy file: $filePath from {$this->getActualPath('extract')} to {$this->getPath('project')}");
        }
        $fileslog[] = $filePath;
      }
    }
    return true;
  }

  /**
  * Run migration
  * @param boolean $up up or down migrations
  * @param integer $down_count count of reverting migrations, if $up=false (means migrate/down)
  */
  public function migrate($up = true, $down_count = 1)
  {
     ob_start();

     $migration = new \yii\console\controllers\MigrateController('migrate', Yii::$app);
     if($up) {
       $migration->runAction('up', ['migrationPath' => '@app/migrations/', 'interactive' => false]);
     } else {
       $migration->runAction('down', [$down_count, 'migrationPath' => '@app/migrations/', 'interactive' => false]);
     }

     $list = ob_get_contents();
     ob_end_clean();

     $this->processLog(trim($list), 'migration');
  }

    /**
   * Recursively removes a folder along with all its files and directories
   *
   * @param String $path
   */
  private function rrmdir($path) {
    $result = true;
    // Open the source directory to read in files
    $i = new \DirectoryIterator($path);
    foreach($i as $f) {
        if($f->isFile()) {
            $result &= unlink($f->getRealPath());
        } else if(!$f->isDot() && $f->isDir()) {
            $result &= $this->rrmdir($f->getRealPath());
        }
    }
    $result &= rmdir($path);
    return $result;
  }

  /**
  * Write log to file
  */
  public function writeLog()
  {
    if(is_array($this->log) && count($this->log) > 0)
    {
      $fileName = $this->getUpdateId();
      $logName = $fileName.".csv";
      $dir = $this->getPath('logs');
      if(!file_exists($dir))
      {
        FileHelper::createDirectory($dir);
      }
      $file = $dir . DIRECTORY_SEPARATOR . $logName;
      $fh = fopen($file, 'a');

      foreach($this->log as $r)
      {
        fputcsv($fh,array_values($r));
      }
      fclose($fh);
    }
  }

  private function getUpdateConfig()
  {
    try {
      if(!$this->updateConfig)
      {
        if($this->getActualFolder())
        {
          $packagesPath = $this->getActualPath('packages');
          $jsonFile = $packagesPath . DIRECTORY_SEPARATOR . "package.json";
          $configString = file_get_contents($jsonFile);
          $config = json_decode($configString, true);
          $this->updateConfig = $config;
        }
      }
      return $this->updateConfig;
    }
    catch (\Exception $e)
    {
      $this->processLog($e->getMessage(), "warning");
      return false;
    }
  }

  public function addError($key, $error)
  {
      if(!isset($this->errors[$key]))
      {
          $this->errors[$key] = [];
      }
      $this->errors[$key][] = $error;
  }

  public function getErrors()
  {
      return $this->errors;
  }
}
