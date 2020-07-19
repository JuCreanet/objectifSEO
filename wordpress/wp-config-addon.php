/***************************************************************************************************************/
/*Constantes à ajouter au fichier wp-config. Attention certaines peuvent déjà avoir été ajoutée par des plugins*/
/***************************************************************************************************************/

//désactive l'éditeur de plugin et de thème du dashboard
define('DISALLOW_FILE_EDIT',true);

//Sécurise login et admin
define ('FORCE_SSL_ADMIN', true);

//Ne pas afficher les rapports d’erreurs mais les mettre dans un log
@ini_set('log_errors','On'); 
@ini_set('display_errors','Off'); 
@ini_set('error_log','/home/path/domain/logs/php_error.log');

//Limite les révisions
define(‘WP_POST_REVISIONS’,5);// ou false 

//délai de 10mn entre les révisions
define('AUTOSAVE_INTERVAL', '600');

//Les modifications sur les images écrasent les fichiers d'origines 
define('IMAGE_EDIT_OVERWRITE', true); 

//Vider la poubelle tous les 10j
define('EMPTY_TRASH_DAYS', '10'); 

//activer le cache
define('WP_CACHE', true); 

//activer la compression 
define('COMPRESS_CSS', true); 
define('COMPRESS_SCRIPTS', true); 
define('CONCATENATE_SCRIPTS', true); 
define('ENFORCE_GZIP', true);