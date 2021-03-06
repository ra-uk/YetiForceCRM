<?php

/**
 * Settings ConfReport module model class.
 *
 * @copyright YetiForce Sp. z o.o
 * @license YetiForce Public License 3.0 (licenses/LicenseEN.txt or yetiforce.com)
 */
class Settings_ConfReport_Module_Model extends Settings_Vtiger_Module_Model
{
	/**
	 * variable has all the files and folder that should be writable.
	 *
	 * @var array
	 */
	public static $writableFilesAndFolders = [
		'Configuration directory' => 'config/',
		'Configuration file' => 'config/config.inc.php',
		'User privileges directory' => 'user_privileges/',
		'Tabdata file' => 'user_privileges/tabdata.php',
		'Menu file' => 'user_privileges/menu_0.php',
		'User privileges file' => 'user_privileges/user_privileges_1.php',
		'Logo directory' => 'public_html/layouts/resources/Logo/',
		'Cache directory' => 'cache/',
		'Address book directory' => 'cache/addressBook/',
		'Image cache directory' => 'cache/images/',
		'Import cache directory' => 'cache/import/',
		'Logs directory' => 'cache/logs/',
		'Session directory' => 'cache/session/',
		'Cache templates directory' => 'cache/templates_c/',
		'Cache upload directory' => 'cache/upload/',
		'Vtlib test directory' => 'cache/vtlib/',
		'Vtlib test HTML directory' => 'cache/vtlib/HTML',
		'Cron modules directory' => 'cron/modules/',
		'Modules directory' => 'modules/',
		'Libraries directory' => 'public_html/libraries/',
		'Storage directory' => 'storage/',
		'Product image directory' => 'storage/Products/',
		'User image directory' => 'storage/Users/',
		'Contact image directory' => 'storage/Contacts/',
		'MailView attachments directory' => 'storage/OSSMailView/',
		'Roundcube directory' => 'public_html/modules/OSSMail/',
	];

	/**
	 * List of libraries.
	 *
	 * @var array
	 */
	public static $library = [
		'LBL_IMAP_SUPPORT' => ['type' => 'f', 'name' => 'imap_open', 'mandatory' => true],
		'LBL_ZLIB_SUPPORT' => ['type' => 'f', 'name' => 'gzinflate', 'mandatory' => true],
		'LBL_PDO_SUPPORT' => ['type' => 'e', 'name' => 'pdo_mysql', 'mandatory' => true],
		'LBL_OPEN_SSL' => ['type' => 'e', 'name' => 'openssl', 'mandatory' => true],
		'LBL_CURL' => ['type' => 'e', 'name' => 'curl', 'mandatory' => true],
		'LBL_GD_LIBRARY' => ['type' => 'e', 'name' => 'gd', 'mandatory' => true],
		'LBL_PCRE_LIBRARY' => ['type' => 'e', 'name' => 'pcre', 'mandatory' => true], //Roundcube
		'LBL_XML_LIBRARY' => ['type' => 'e', 'name' => 'xml', 'mandatory' => true],
		'LBL_JSON_LIBRARY' => ['type' => 'e', 'name' => 'json', 'mandatory' => true],
		'LBL_SESSION_LIBRARY' => ['type' => 'e', 'name' => 'session', 'mandatory' => true],
		'LBL_DOM_LIBRARY' => ['type' => 'e', 'name' => 'dom', 'mandatory' => true],
		'LBL_ZIP_ARCHIVE' => ['type' => 'e', 'name' => 'zip', 'mandatory' => true],
		'LBL_MBSTRING_LIBRARY' => ['type' => 'e', 'name' => 'mbstring', 'mandatory' => true],
		'LBL_SOAP_LIBRARY' => ['type' => 'e', 'name' => 'soap', 'mandatory' => true],
		'LBL_MYSQLND_LIBRARY' => ['type' => 'e', 'name' => 'mysqlnd', 'mandatory' => true],
		'LBL_FILEINFO_LIBRARY' => ['type' => 'e', 'name' => 'fileinfo', 'mandatory' => true],
		'LBL_LIBICONV_LIBRARY' => ['type' => 'e', 'name' => 'iconv', 'mandatory' => true],
		'LBL_EXIF_LIBRARY' => ['type' => 'f', 'name' => 'exif_read_data', 'mandatory' => false],
		'LBL_LDAP_LIBRARY' => ['type' => 'f', 'name' => 'ldap_connect', 'mandatory' => false],
		'LBL_OPCACHE_LIBRARY' => ['type' => 'f', 'name' => 'opcache_get_configuration', 'mandatory' => false],
		'LBL_APCU_LIBRARY' => ['type' => 'e', 'name' => 'apcu', 'mandatory' => false],
	];

	private static function getStabilitIniConf()
	{
		$directiveValues = [
			'PHP' => ['recommended' => '7.1.x, 7.1.x, 7.2.x (dev)', 'help' => 'LBL_PHP_HELP_TEXT', 'fn' => 'validatePhp', 'max' => '7.1'],
			'error_reporting' => ['recommended' => 'E_ALL & ~E_NOTICE', 'help' => 'LBL_ERROR_REPORTING_HELP_TEXT', 'fn' => 'validateErrorReporting'],
			'output_buffering' => ['recommended' => 'On', 'help' => 'LBL_OUTPUT_BUFFERING_HELP_TEXT', 'fn' => 'validateOnOffInt'],
			'max_execution_time' => ['recommended' => '600', 'help' => 'LBL_MAX_EXECUTION_TIME_HELP_TEXT', 'fn' => 'validateGreater'],
			'max_input_time' => ['recommended' => '600', 'help' => 'LBL_MAX_INPUT_TIME_HELP_TEXT', 'fn' => 'validateGreater'],
			'default_socket_timeout' => ['recommended' => '600', 'help' => 'LBL_DEFAULT_SOCKET_TIMEOUT_HELP_TEXT', 'fn' => 'validateGreater'],
			'memory_limit' => ['recommended' => '512 MB', 'help' => 'LBL_MEMORY_LIMIT_HELP_TEXT', 'fn' => 'validateGreaterMb'],
			'log_errors' => ['recommended' => 'On', 'help' => 'LBL_LOG_ERRORS_HELP_TEXT', 'fn' => 'validateOnOff'],
			'file_uploads' => ['recommended' => 'On', 'help' => 'LBL_FILE_UPLOADS_HELP_TEXT', 'fn' => 'validateOnOff'],
			'short_open_tag' => ['recommended' => 'On', 'help' => 'LBL_SHORT_OPEN_TAG_HELP_TEXT', 'fn' => 'validateOnOff'],
			'post_max_size' => ['recommended' => '50 MB', 'help' => 'LBL_POST_MAX_SIZE_HELP_TEXT', 'fn' => 'validateGreaterMb'],
			'upload_max_filesize' => ['recommended' => '100 MB', 'help' => 'LBL_UPLOAD_MAX_FILESIZE_HELP_TEXT', 'fn' => 'validateGreaterMb'],
			'max_input_vars' => ['recommended' => '10000', 'help' => 'LBL_MAX_INPUT_VARS_HELP_TEXT', 'fn' => 'validateGreater'],
			'zlib.output_compression' => ['recommended' => 'Off', 'help' => 'LBL_ZLIB_OUTPUT_COMPRESSION_HELP_TEXT', 'fn' => 'validateOnOff'],
			'session.auto_start' => ['recommended' => 'Off', 'help' => 'LBL_SESSION_AUTO_START_HELP_TEXT', 'fn' => 'validateOnOff'],
			'session.gc_maxlifetime' => ['recommended' => '21600', 'help' => 'LBL_SESSION_GC_MAXLIFETIME_HELP_TEXT', 'fn' => 'validateGreater'],
			'session.gc_divisor' => ['recommended' => '500', 'help' => 'LBL_SESSION_GC_DIVISOR_HELP_TEXT', 'fn' => 'validateGreater'],
			'session.gc_probability' => ['recommended' => '1', 'help' => 'LBL_SESSION_GC_PROBABILITY_HELP_TEXT', 'fn' => 'validateEqual'],
			'mbstring.func_overload' => ['recommended' => 'Off', 'help' => 'LBL_MBSTRING_FUNC_OVERLOAD_HELP_TEXT', 'fn' => 'validateOnOff'], //Roundcube
			'date.timezone' => ['recommended' => false, 'fn' => 'validateTimezone'], //Roundcube
			'allow_url_fopen' => ['recommended' => 'On', 'help' => 'LBL_ALLOW_URL_FOPEN_HELP_TEXT', 'fn' => 'validateOnOff'], //Roundcube
			'auto_detect_line_endings' => ['recommended' => 'On', 'help' => 'LBL_AUTO_DETECT_LINE_ENDINGS_HELP_TEXT', 'fn' => 'validateOnOff'], //CSVReader
		];
		if (extension_loaded('suhosin')) {
			$directiveValues['suhosin.session.encrypt'] = ['recommended' => 'Off', 'fn' => 'validateOnOff']; //Roundcube
			$directiveValues['suhosin.request.max_vars'] = ['recommended' => '5000', 'fn' => 'validateGreater'];
			$directiveValues['suhosin.post.max_vars'] = ['recommended' => '5000', 'fn' => 'validateGreater'];
			$directiveValues['suhosin.post.max_value_length'] = ['recommended' => '1500000', 'fn' => 'validateGreater'];
		}

		return $directiveValues;
	}

	public static function getLibrary()
	{
		foreach (static::$library as $k => $v) {
			if ($v['type'] == 'f') {
				$status = function_exists($v['name']);
			} elseif ($v['type'] == 'e') {
				$status = extension_loaded($v['name']);
			}
			static::$library[$k]['status'] = $status ? 'LBL_YES' : 'LBL_NO';
		}

		return static::$library;
	}

	/**
	 * Get system stability configuration.
	 *
	 * @param bool $instalMode
	 *
	 * @return array
	 */
	public static function getStabilityConf($instalMode = false, $onlyError = false, $cli = false)
	{
		$ini = static::getPhpIniConf();
		$conf = static::getStabilitIniConf();
		$cliConf = false;
		if ($cli) {
			$cliConf = static::getPhpIniConfCron();
		}
		foreach ($conf as $key => &$value) {
			if ($cliConf) {
				$value['cli'] = $value['current'] = $cliConf[$key];
				if (isset($value['fn'])) {
					$value = call_user_func_array([__CLASS__, $value['fn']], [$value, true]);
					$value['cli'] = $value['current'];
				}
			}
			$value['current'] = $ini[$key];
			if (isset($value['fn'])) {
				$value = call_user_func_array([__CLASS__, $value['fn']], [$value, false]);
				unset($value['fn']);
			}
		}
		if ($onlyError) {
			foreach ($conf as $key => $value) {
				if (empty($value['incorrect'])) {
					unset($conf[$key]);
				}
			}
		}

		return $conf;
	}

	/**
	 * Get system security configuration.
	 *
	 * @param bool $instalMode
	 *
	 * @return array
	 */
	public static function getSecurityConf($instalMode = false, $onlyError = false)
	{
		$directiveValues = [
			'display_errors' => [
				'recommended' => 'Off',
				'help' => 'LBL_DISPLAY_ERRORS_HELP_TEXT',
				'current' => static::getFlag(ini_get('display_errors')),
				'status' => \AppConfig::main('systemMode') !== 'demo' && (ini_get('display_errors') == 1 || stripos(ini_get('display_errors'), 'On') !== false),
			],
			'HTTPS' => ['recommended' => 'On', 'help' => 'LBL_HTTPS_HELP_TEXT'],
			'.htaccess' => ['recommended' => 'On', 'help' => 'LBL_HTACCESS_HELP_TEXT'],
			'public_html' => ['recommended' => 'On', 'help' => 'LBL_PUBLIC_HTML_HELP_TEXT'],
			'session.use_strict_mode' => [
				'recommended' => 'On',
				'help' => 'LBL_SESSION_USE_STRICT_MODE_HELP_TEXT',
				'current' => static::getFlag(ini_get('session.use_strict_mode')),
				'status' => ini_get('session.use_strict_mode') != 1 && stripos(ini_get('session.use_strict_mode'), 'Off') !== false,
			],
			'session.use_trans_sid' => [
				'recommended' => 'Off',
				'help' => 'LBL_SESSION_USE_TRANS_SID_HELP_TEXT',
				'current' => static::getFlag(ini_get('session.use_trans_sid')),
				'status' => ini_get('session.use_trans_sid') == 1 || stripos(ini_get('session.use_trans_sid'), 'On') !== false,
			],
			'session.cookie_httponly' => [
				'recommended' => 'On',
				'help' => 'LBL_SESSION_COOKIE_HTTPONLY_HELP_TEXT',
				'current' => static::getFlag(ini_get('session.cookie_httponly')),
				'status' => ini_get('session.cookie_httponly') != 1 && stripos(ini_get('session.cookie_httponly'), 'Off') !== false,
			],
			'session.use_only_cookies' => [
				'recommended' => 'On',
				'help' => 'LBL_SESSION_USE_ONLY_COOKIES_HELP_TEXT',
				'current' => static::getFlag(ini_get('session.use_only_cookies')),
				'status' => ini_get('session.use_only_cookies') != 1 && stripos(ini_get('session.use_only_cookies'), 'Off') !== false,
			],
			'expose_php' => [
				'recommended' => 'Off',
				'help' => 'LBL_EXPOSE_PHP_HELP_TEXT',
				'current' => static::getFlag(ini_get('expose_php')),
				'status' => ini_get('expose_php') == 1 || stripos(ini_get('expose_php'), 'On') !== false,
			],
			'session_regenerate_id' => [
				'recommended' => 'On',
				'help' => 'LBL_SESSION_REGENERATE_HELP_TEXT',
				'current' => static::getFlag(AppConfig::main('session_regenerate_id')),
				'status' => AppConfig::main('session_regenerate_id') !== null && !AppConfig::main('session_regenerate_id'),
			],
			'Header: X-Frame-Options' => ['recommended' => 'SAMEORIGIN', 'help' => 'LBL_HEADER_X_FRAME_OPTIONS_HELP_TEXT', 'current' => '?'],
			'Header: X-XSS-Protection' => ['recommended' => '1; mode=block', 'help' => 'LBL_HEADER_X_XSS_PROTECTION_HELP_TEXT', 'current' => '?'],
			'Header: X-Content-Type-Options' => ['recommended' => 'nosniff', 'help' => 'LBL_HEADER_X_CONTENT_TYPE_OPTIONS_HELP_TEXT', 'current' => '?'],
			'Header: X-Robots-Tag' => ['recommended' => 'none', 'help' => 'LBL_HEADER_X_ROBOTS_TAG_HELP_TEXT', 'current' => '?'],
			'Header: X-Permitted-Cross-Domain-Policies' => ['recommended' => 'none', 'help' => 'LBL_HEADER_X_PERMITTED_CROSS_DOMAIN_POLICIES_HELP_TEXT', 'current' => '?'],
			'Header: X-Powered-By' => ['recommended' => '', 'help' => 'LBL_HEADER_X_POWERED_BY_HELP_TEXT', 'current' => '?'],
			'Header: Server' => ['recommended' => '', 'help' => 'LBL_HEADER_SERVER_HELP_TEXT', 'current' => '?'],
			'Header: Expect-CT' => ['recommended' => 'enforce; max-age=3600', 'help' => 'LBL_HEADER_EXPECT_CT_HELP_TEXT', 'current' => '?'],
			'Header: Referrer-Policy' => ['recommended' => 'same-origin', 'help' => 'LBL_HEADER_REFERRER_POLICY_HELP_TEXT', 'current' => '?'],
			'Header: Strict-Transport-Security' => ['recommended' => 'max-age=31536000; includeSubDomains; preload', 'help' => 'LBL_HEADER_STRICT_TRANSPORT_SECURITY_HELP_TEXT', 'current' => '?'],
		];
		if (IS_PUBLIC_DIR === true) {
			$directiveValues['public_html']['current'] = static::getFlag(true);
		} else {
			$directiveValues['public_html']['status'] = true;
			$directiveValues['public_html']['current'] = static::getFlag(false);
		}
		if (!isset($_SERVER['HTACCESS_TEST'])) {
			$directiveValues['.htaccess']['status'] = true;
			$directiveValues['.htaccess']['current'] = 'Off';
		} else {
			$directiveValues['.htaccess']['current'] = 'On';
		}
		if (App\RequestUtil::getBrowserInfo()->https) {
			$directiveValues['HTTPS']['status'] = false;
			$directiveValues['HTTPS']['current'] = static::getFlag(true);
			$directiveValues['session.cookie_secure'] = ['recommended' => 'On'];
			if (ini_get('session.cookie_secure') != '1' && stripos(ini_get('session.cookie_secure'), 'On') !== false) {
				$directiveValues['session.cookie_secure']['status'] = true;
				$directiveValues['session.cookie_secure']['current'] = static::getFlag(false);
			} else {
				$directiveValues['session.cookie_secure']['current'] = static::getFlag(true);
			}
		} else {
			$directiveValues['HTTPS']['status'] = true;
			$directiveValues['HTTPS']['current'] = static::getFlag(false);
			if (ini_get('session.cookie_secure') == '1' || stripos(ini_get('session.cookie_secure'), 'On') === false) {
				$directiveValues['session.cookie_secure']['current'] = static::getFlag(true);
				$directiveValues['session.cookie_secure']['recommended'] = static::getFlag(false);
				$directiveValues['session.cookie_secure']['status'] = true;
			}
		}
		stream_context_set_default([
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
			],
		]);
		$requestUrl = (\App\RequestUtil::getBrowserInfo()->https ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
		$rqheaders = get_headers($requestUrl, 1);
		if ($rqheaders) {
			$headers = array_change_key_case($rqheaders, CASE_UPPER);
			if (stripos($headers[0], '200') === false) {
				$headers = [];
			}
		}
		if ($headers) {
			$directiveValues['Header: X-Frame-Options']['status'] = strtolower($headers['X-FRAME-OPTIONS']) !== 'sameorigin';
			$directiveValues['Header: X-Frame-Options']['current'] = $headers['X-FRAME-OPTIONS'];
			$directiveValues['Header: X-XSS-Protection']['status'] = strtolower($headers['X-XSS-PROTECTION']) !== '1; mode=block';
			$directiveValues['Header: X-XSS-Protection']['current'] = $headers['X-XSS-PROTECTION'];
			$directiveValues['Header: X-Content-Type-Options']['status'] = strtolower($headers['X-CONTENT-TYPE-OPTIONS']) !== 'nosniff';
			$directiveValues['Header: X-Content-Type-Options']['current'] = $headers['X-CONTENT-TYPE-OPTIONS'];
			$directiveValues['Header: X-Powered-By']['status'] = !empty($headers['X-POWERED-BY']);
			$directiveValues['Header: X-Powered-By']['current'] = $headers['X-POWERED-BY'];
			$directiveValues['Header: X-Robots-Tag']['status'] = strtolower($headers['X-ROBOTS-TAG']) !== 'none';
			$directiveValues['Header: X-Robots-Tag']['current'] = $headers['X-ROBOTS-TAG'];
			$directiveValues['Header: X-Permitted-Cross-Domain-Policies']['status'] = strtolower($headers['X-PERMITTED-CROSS-DOMAIN-POLICIES']) !== 'none';
			$directiveValues['Header: X-Permitted-Cross-Domain-Policies']['current'] = $headers['X-PERMITTED-CROSS-DOMAIN-POLICIES'];
			$directiveValues['Header: X-Powered-By']['status'] = !empty($headers['X-POWERED-BY']);
			$directiveValues['Header: X-Powered-By']['current'] = $headers['X-POWERED-BY'];
			$directiveValues['Header: Server']['status'] = !empty($headers['SERVER']);
			$directiveValues['Header: Server']['current'] = $headers['SERVER'];
			$directiveValues['Header: Referrer-Policy']['status'] = strtolower($headers['REFERRER-POLICY']) !== 'no-referrer';
			$directiveValues['Header: Referrer-Policy']['current'] = $headers['REFERRER-POLICY'];
			$directiveValues['Header: Expect-CT']['status'] = strtolower($headers['EXPECT-CT']) !== 'enforce; max-age=3600';
			$directiveValues['Header: Expect-CT']['current'] = $headers['EXPECT-CT'];
			$directiveValues['Header: Strict-Transport-Security']['status'] = strtolower($headers['STRICT-TRANSPORT-SECURITY']) !== 'max-age=31536000; includesubdomains; preload';
			$directiveValues['Header: Strict-Transport-Security']['current'] = $headers['STRICT-TRANSPORT-SECURITY'];
		}
		if ($onlyError) {
			foreach ($directiveValues as $key => $value) {
				if (empty($value['status'])) {
					unset($directiveValues[$key]);
				}
			}
		}

		return $directiveValues;
	}

	/**
	 * @param type $onlyError
	 *
	 * @return bool
	 */
	public static function getDbConf($onlyError = false)
	{
		$db = \App\Db::getInstance();
		$directiveValues = [
			'LBL_DB_DRIVER' => ['recommended' => 'mysql', 'current' => $db->getDriverName(), 'help' => 'LBL_DB_DRIVER_HELP_TEXT'],
			'LBL_DB_SERVER_VERSION' => ['recommended' => false, 'current' => $db->getSlavePdo()->getAttribute(PDO::ATTR_SERVER_VERSION)],
			'LBL_DB_CLIENT_VERSION' => ['recommended' => false, 'current' => $db->getSlavePdo()->getAttribute(PDO::ATTR_CLIENT_VERSION)],
			'LBL_DB_CONNECTION_STATUS' => ['recommended' => false, 'current' => $db->getSlavePdo()->getAttribute(PDO::ATTR_CONNECTION_STATUS)],
			'LBL_DB_SERVER_INFO' => ['recommended' => false, 'current' => $db->getSlavePdo()->getAttribute(PDO::ATTR_SERVER_INFO)],
		];
		if (!in_array($db->getDriverName(), explode(',', $directiveValues['LBL_DB_DRIVER']['recommended']))) {
			$directiveValues['wait_timeout']['status'] = true;
		}
		if ($db->getDriverName() === 'mysql') {
			$directiveValues = array_merge($directiveValues, [
				'innodb_lock_wait_timeout' => ['recommended' => '600', 'help' => 'LBL_INNODB_LOCK_WAIT_TIMEOUT_HELP_TEXT'],
				'wait_timeout' => ['recommended' => '600', 'help' => 'LBL_WAIT_TIMEOUT_HELP_TEXT'],
				'interactive_timeout' => ['recommended' => '600', 'help' => 'LBL_INTERACTIVE_TIMEOUT_HELP_TEXT'],
				'sql_mode' => ['recommended' => '', 'help' => 'LBL_SQL_MODE_HELP_TEXT'],
				'max_allowed_packet' => ['recommended' => '10 MB', 'help' => 'LBL_MAX_ALLOWED_PACKET_HELP_TEXT'],
				'log_error' => ['recommended' => false],
				'max_connections' => ['recommended' => false],
				'thread_cache_size' => ['recommended' => false],
				'key_buffer_size' => ['recommended' => false],
				'query_cache_size' => ['recommended' => false],
				'tmp_table_size' => ['recommended' => false],
				'max_heap_table_size' => ['recommended' => false],
				'innodb_file_per_table' => ['recommended' => 'On', 'help' => 'LBL_INNODB_FILE_PER_TABLE_HELP_TEXT'],
				'innodb_stats_on_metadata' => ['recommended' => 'Off', 'help' => 'LBL_INNODB_STATS_ON_METADATA_HELP_TEXT'],
				'innodb_buffer_pool_instances' => ['recommended' => false],
				'innodb_buffer_pool_size' => ['recommended' => false],
				'innodb_log_file_size' => ['recommended' => false],
				'innodb_io_capacity_max' => ['recommended' => false],
			]);
			$conf = $db->createCommand('SHOW VARIABLES')->queryAllByGroup(0);
			$directiveValues['max_allowed_packet']['current'] = vtlib\Functions::showBytes($conf['max_allowed_packet']);
			$directiveValues['innodb_log_file_size']['current'] = vtlib\Functions::showBytes($conf['innodb_log_file_size']);
			$directiveValues['key_buffer_size']['current'] = vtlib\Functions::showBytes($conf['key_buffer_size']);
			$directiveValues['query_cache_size']['current'] = vtlib\Functions::showBytes($conf['query_cache_size']);
			$directiveValues['tmp_table_size']['current'] = vtlib\Functions::showBytes($conf['tmp_table_size']);
			$directiveValues['max_heap_table_size']['current'] = vtlib\Functions::showBytes($conf['max_heap_table_size']);
			$directiveValues['innodb_buffer_pool_size']['current'] = vtlib\Functions::showBytes($conf['innodb_buffer_pool_size']);
			$directiveValues['innodb_log_file_size']['current'] = vtlib\Functions::showBytes($conf['innodb_log_file_size']);
			$directiveValues['innodb_lock_wait_timeout']['current'] = $conf['innodb_lock_wait_timeout'];
			$directiveValues['wait_timeout']['current'] = $conf['wait_timeout'];
			$directiveValues['interactive_timeout']['current'] = $conf['interactive_timeout'];
			$directiveValues['sql_mode']['current'] = $conf['sql_mode'];
			$directiveValues['log_error']['current'] = $conf['log_error'];
			$directiveValues['max_connections']['current'] = $conf['max_connections'];
			$directiveValues['thread_cache_size']['current'] = $conf['thread_cache_size'];
			$directiveValues['innodb_buffer_pool_instances']['current'] = $conf['innodb_buffer_pool_instances'];
			$directiveValues['innodb_io_capacity_max']['current'] = $conf['innodb_io_capacity_max'];
			$directiveValues['innodb_file_per_table']['current'] = $conf['innodb_file_per_table'];
			$directiveValues['innodb_stats_on_metadata']['current'] = $conf['innodb_stats_on_metadata'];
			if (isset($conf['tx_isolation'])) {
				$directiveValues['tx_isolation'] = ['current' => $conf['tx_isolation'], 'recommended' => false];
			}
			if (isset($conf['transaction_isolation'])) {
				$directiveValues['transaction_isolation'] = ['current' => $conf['transaction_isolation'], 'recommended' => false];
			}
			if ($conf['max_allowed_packet'] < 16777216) {
				$directiveValues['max_allowed_packet']['status'] = true;
			}
			if ($conf['innodb_lock_wait_timeout'] < 600) {
				$directiveValues['innodb_lock_wait_timeout']['status'] = true;
			}
			if ($conf['wait_timeout'] < 600) {
				$directiveValues['wait_timeout']['status'] = true;
			}
			if ($conf['interactive_timeout'] < 600) {
				$directiveValues['interactive_timeout']['status'] = true;
			}
			if (!empty($conf['sql_mode']) && (strpos($conf['sql_mode'], 'STRICT_TRANS_TABLE') !== false || strpos($conf['sql_mode'], 'ONLY_FULL_GROUP_BY') !== false)) {
				$directiveValues['sql_mode']['status'] = true;
			}
		}
		if ($onlyError) {
			foreach ($directiveValues as $key => $value) {
				if (empty($value['status'])) {
					unset($directiveValues[$key]);
				}
			}
		}

		return $directiveValues;
	}

	/**
	 * Get system details.
	 *
	 * @return array
	 */
	public static function getSystemInfo()
	{
		$ini = static::getPhpIniConf();
		$cliConf = static::getPhpIniConfCron();
		$dir = ROOT_DIRECTORY . DIRECTORY_SEPARATOR;
		$params = [
			'LBL_OPERATING_SYSTEM' => \AppConfig::main('systemMode') === 'demo' ? php_uname('s') : php_uname(),
			'LBL_TMP_DIR' => App\Fields\File::getTmpPath(),
			'LBL_CRM_DIR' => ROOT_DIRECTORY,
			'LBL_PHP_SAPI' => ['www' => $ini['SAPI'], 'cli' => $cliConf ? $cliConf['SAPI'] : ''],
			'LBL_LOG_FILE' => ['www' => $ini['LOG_FILE'], 'cli' => $cliConf ? $cliConf['LOG_FILE'] : ''],
			'LBL_PHPINI' => ['www' => $ini['INI_FILE'], 'cli' => $cliConf ? $cliConf['INI_FILE'] : ''],
			'LBL_SPACE' => App\Language::translateSingleMod('LBL_SPACE_FREE', 'Settings::ConfReport') . ': ' . \vtlib\Functions::showBytes(disk_free_space($dir)) . ', ' . App\Language::translateSingleMod('LBL_SPACE_USED', 'Settings::ConfReport') . ': ' . \vtlib\Functions::showBytes(disk_total_space($dir) - disk_free_space($dir)),
		];
		if (!empty($ini['INI_FILES']) || !empty($cliConf['INI_FILES'])) {
			$params['LBL_PHPINIS'] = ['www' => $ini['INI_FILES'], 'cli' => $cliConf ? $cliConf['INI_FILES'] : ''];
		}

		return $params;
	}

	/**
	 * Get deny URLs.
	 *
	 * @return array
	 */
	public static function getDenyPublicDirState()
	{
		$baseUrl = \AppConfig::main('site_URL');
		$denyPublicDirState = [
			'config/' => ['help' => 'LBL_DENY_PUBLIC_DIR_HELP_TEXT', 'status' => \App\Fields\File::isExistsUrl($baseUrl . 'config')],
			'cache/' => ['help' => 'LBL_DENY_PUBLIC_DIR_HELP_TEXT', 'status' => \App\Fields\File::isExistsUrl($baseUrl . 'cache')],
			'storage/' => ['help' => 'LBL_DENY_PUBLIC_DIR_HELP_TEXT', 'status' => \App\Fields\File::isExistsUrl($baseUrl . 'storage')],
			'user_privileges/' => ['help' => 'LBL_DENY_PUBLIC_DIR_HELP_TEXT', 'status' => \App\Fields\File::isExistsUrl($baseUrl . 'user_privileges')],
		];

		return $denyPublicDirState;
	}

	/**
	 * Function returns permissions to the core files and folder.
	 *
	 * @return <Array>
	 */
	public static function getPermissionsFiles($onlyError = false)
	{
		$writableFilesAndFolders = static::$writableFilesAndFolders;
		$permissions = [];
		require_once ROOT_DIRECTORY . '/include/utils/VtlibUtils.php';
		foreach ($writableFilesAndFolders as $index => $value) {
			$isWriteable = \App\Fields\File::isWriteable($value);
			if (!$isWriteable || !$onlyError) {
				$permissions[$index]['permission'] = 'TruePermission';
				$permissions[$index]['path'] = $value;
			}
			if (!$isWriteable) {
				$permissions[$index]['permission'] = 'FailedPermission';
			}
		}

		return $permissions;
	}

	/**
	 * Get php.ini configuration.
	 *
	 * @return array
	 */
	public static function getPhpIniConf()
	{
		$iniAll = ini_get_all();
		$values = [];
		foreach (static::getStabilitIniConf() as $key => $value) {
			if (isset($iniAll[$key])) {
				$values[$key] = $iniAll[$key]['local_value'];
			}
		}
		$values['PHP'] = PHP_VERSION;
		$values['SAPI'] = PHP_SAPI;
		$values['INI_FILE'] = php_ini_loaded_file();
		$values['INI_FILES'] = php_ini_scanned_files();
		$values['LOG_FILE'] = $iniAll['error_log']['local_value'];

		return $values;
	}

	/**
	 * Get php.ini configuration from CLI.
	 *
	 * @return bool|array
	 */
	public static function getPhpIniConfCron()
	{
		if (file_exists('user_privileges/cron.php')) {
			return include 'user_privileges/cron.php';
		}

		return false;
	}

	/**
	 * Test server speed.
	 *
	 * @return array
	 */
	public static function testSpeed()
	{
		$dir = ROOT_DIRECTORY . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR . 'speed' . DIRECTORY_SEPARATOR;
		if (!is_dir($dir)) {
			mkdir($dir, 0755);
		}
		$i = 5000;
		$p = time();
		$writeS = microtime(true);
		for ($index = 0; $index < $i; ++$index) {
			file_put_contents("{$dir}{$p}{$index}.php", '<?php return [];');
		}
		$writeE = microtime(true);
		$iterator = new \DirectoryIterator($dir);
		$readS = microtime(true);
		foreach ($iterator as $item) {
			if (!$item->isDot() && !$item->isDir()) {
				include $item->getPathname();
			}
		}
		$readE = microtime(true);
		$read = $i / ($readE - $readS);
		$write = $i / ($writeE - $writeS);
		\vtlib\Functions::recurseDelete('cache/speed');

		return ['FilesRead' => number_format($read, 0, '', ' '), 'FilesWrite' => number_format($write, 0, '', ' ')];
	}

	/**
	 * Validate number greater than recommended.
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validateGreater($row, $isCli)
	{
		if ((int) $row['current'] > 0 && (int) $row['current'] < $row['recommended']) {
			$row['incorrect'] = true;
		}

		return $row;
	}

	/**
	 * Validate number in bytes greater than recommended.
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validateGreaterMb($row, $isCli)
	{
		if (vtlib\Functions::parseBytes($row['current']) < vtlib\Functions::parseBytes($row['recommended'])) {
			$row['incorrect'] = true;
		}
		$row['current'] = vtlib\Functions::showBytes($row['current']);

		return $row;
	}

	/**
	 * Validate on and off values.
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validateOnOff($row, $isCli)
	{
		static $map = ['on' => true, 'true' => true, 'off' => false, 'false' => false];
		$current = isset($map[strtolower($row['current'])]) ? $map[strtolower($row['current'])] : (bool) $row['current'];
		if ($current !== ($row['recommended'] === 'On')) {
			$row['incorrect'] = true;
		}
		if (is_bool($current)) {
			$row['current'] = $current ? 'On' : 'Off';
		} else {
			$row['current'] = static::getFlag($row['current']);
		}

		return $row;
	}

	/**
	 * Validate on, off and int values.
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validateOnOffInt($row, $isCli)
	{
		if (!$isCli && strtolower($row['current']) !== 'on') {
			$row['incorrect'] = true;
		}

		return $row;
	}

	/**
	 * Validate equal value "recommended == current".
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validateEqual($row, $isCli)
	{
		if ((int) $row['current'] !== (int) $row['recommended']) {
			$row['incorrect'] = true;
		}

		return $row;
	}

	/**
	 * Validate php version.
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validatePhp($row, $isCli)
	{
		try {
			$newest = static::getNewestPhpVersion($row['max']);
		} catch (Exception $exc) {
			$newest = false;
		}
		if ($newest) {
			$row['recommended'] = $newest;
		}
		if (version_compare($row['current'], str_replace('x', 0, $row['recommended']), '<')) {
			$row['incorrect'] = true;
		}

		return $row;
	}

	/**
	 * Validate date timezone.
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validateTimezone($row, $isCli)
	{
		try {
			new DateTimeZone($row['current']);
		} catch (Exception $e) {
			$row['current'] = \App\Language::translate('LBL_INVALID_TIME_ZONE', 'Settings::ConfReport') . $row['current'];
			$row['incorrect'] = true;
		}

		return $row;
	}

	/**
	 * Validate error reporting.
	 *
	 * @param mixed $row
	 *
	 * @return mixed
	 */
	public static function validateErrorReporting($row, $isCli)
	{
		$errorReporting = stripos($row['current'], '_') === false ? \App\ErrorHandler::error2string($row['current']) : $row['current'];
		if (in_array('E_NOTICE', $errorReporting) || in_array('E_ALL', $errorReporting)) {
			$row['incorrect'] = true;
		}
		$row['current'] = implode(' | ', $errorReporting);

		return $row;
	}

	/**
	 * Get actual version of PHP.
	 *
	 * @param string $version eg. "5.6", "7.1"
	 *
	 * @return string eg. 7.1.12
	 */
	private static function getNewestPhpVersion(string $version)
	{
		if (!class_exists('Requests')) {
			return false;
		}
		$resonse = Requests::get('http://php.net/releases/index.php?json&max=10&version=' . $version[0]);
		$data = array_keys((array) \App\Json::decode($resonse->body));
		natsort($data);
		foreach (array_reverse($data) as $ver) {
			if (strpos($ver, $version) === 0) {
				return $ver;
			}
		}

		return false;
	}

	/**
	 * Get ini flag.
	 *
	 * @param mixed $val
	 *
	 * @return string
	 */
	private static function getFlag($val)
	{
		if ($val == 'On' || $val == 1 || stripos($val, 'On') !== false) {
			return 'On';
		}

		return 'Off';
	}
}
