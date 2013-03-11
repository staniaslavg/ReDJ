CREATE TABLE IF NOT EXISTS `#__redj_redirects` (
  `id` int(11) NOT NULL auto_increment,
  `fromurl` varchar(255) NOT NULL DEFAULT '',
  `tourl` varchar(255) DEFAULT NULL,
  `redirect` int(3) unsigned NOT NULL DEFAULT '301' COMMENT 'HTTP STATUS CODE: 301, 307, 200',
  `case_sensitive` tinyint(1) NOT NULL DEFAULT '1',
  `request_only` tinyint(1) NOT NULL DEFAULT '1',
  `decode_url` tinyint(1) NOT NULL DEFAULT '1',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `last_visit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ordering` int(11) NOT NULL DEFAULT '0',
  `published` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'publish = 1, unpublish = 0, archive = 2, trash = -2, report = -3',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idxfromurl` (`fromurl`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__redj_pages404` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL DEFAULT '',
  `language` varchar(5) NOT NULL DEFAULT '',
  `page` mediumtext NOT NULL,
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `last_visit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `checked_out` int(11) unsigned NOT NULL DEFAULT '0',
  `checked_out_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__redj_errors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visited_url` varchar(255) NOT NULL DEFAULT '',
  `error_code` int(3) NOT NULL DEFAULT '0',
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `last_visit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_referer` varchar(255) DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_visited_url_error_code` (`visited_url`,`error_code`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__redj_visited_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visited_url` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_visited_url` (`visited_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__redj_referer_urls` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `referer_url` varchar(255) DEFAULT '',
  `domain` varchar(255) NOT NULL DEFAULT '' COMMENT 'The "host" part of the referer url',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_referer_url` (`referer_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `#__redj_referers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `visited_url` int(11) NOT NULL,
  `referer_url` int(11) NOT NULL,
  `hits` int(11) unsigned NOT NULL DEFAULT '0',
  `last_visit` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_visited_url_referer_url` (`visited_url`,`referer_url`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- -------------------------------
-- Default Custom Error 404 pages
-- -------------------------------
DELETE FROM `#__redj_pages404` WHERE `id` IN ('1', '2');
INSERT INTO `#__redj_pages404` (`id`, `title`, `language`, `page`, `hits`, `last_visit`, `checked_out`, `checked_out_time`) VALUES (1,'Italiano','it-IT','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"it-it\" lang=\"it-it\" dir=\"ltr\">\n<head>\n  <base href=\"http://{siteurl}\">\n  <title>{sitename} - Errore 404: {errormessage}</title>\n  <link rel=\"stylesheet\" href=\"http://{siteurl}/templates/system/css/error.css\" type=\"text/css\" />\n</head>\n<body>\n  <div align=\"center\">\n    <div id=\"outline\">\n    <div id=\"errorboxoutline\">\n      <div id=\"errorboxheader\">Errore 404 - {errormessage}</div>\n\n      <div id=\"errorboxbody\">\n      <p><strong>Non &egrave; possibile visualizzare questa pagina a causa di:</strong></p>\n        <ol>\n          <li>un <strong>bookmark/preferiti scaduto</strong></li>\n          <li>una ricerca attraverso il motore di ricerca che ha <strong>una lista scaduta per questo sito</strong></li>\n          <li>un <strong>indirizzo compilato male</strong></li>\n\n          <li><strong>Non hai accesso</strong> a questa pagina</li>\n          <li>La risorsa richiesta <strong>non esiste</strong></li>\n          <li>Si &egrave; verificato un errore durante l\'esecuzione della tua richiesta.</li>\n        </ol>\n      <p><strong>Prova una delle seguenti pagine:</strong></p>\n\n      <p>\n        <ul>\n          <li><a href=\"http://{siteurl}/index.php\" title=\"Vai alla Home Page\">Home</a></li>\n        </ul>\n      </p>\n\n      <p>Se persistono delle difficolt&agrave;, <a href=\"mailto:{sitemail}\">contatta</a> l\'Amministratore di questo sito.</p>\n\n      <div id=\"techinfo\">\n      <p>{errormessage}</p>\n      </div>\n\n      </div>\n    </div>\n    </div>\n  </div>\n</body>\n</html>', 0, '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');
INSERT INTO `#__redj_pages404` (`id`, `title`, `language`, `page`, `hits`, `last_visit`, `checked_out`, `checked_out_time`) VALUES ('2', 'English', 'en-GB', '<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en-gb\" lang=\"en-gb\" dir=\"ltr\">\n<head>\n  <base href=\"http://{siteurl}\">\n  <title>{sitename} - Error 404: {errormessage}</title>\n  <link rel=\"stylesheet\" href=\"http://{siteurl}/templates/system/css/error.css\" type=\"text/css\" />\n</head>\n<body>\n  <div align=\"center\">\n    <div id=\"outline\">\n    <div id=\"errorboxoutline\">\n      <div id=\"errorboxheader\">Error 404 - {errormessage}</div>\n\n      <div id=\"errorboxbody\">\n      <p><strong>You may not be able to visit this page because of:</strong></p>\n        <ol>\n          <li>an <strong>out-of-date bookmark/favourite</strong></li>\n          <li>a search engine that has an <strong>out-of-date listing for this site</strong></li>\n          <li>a <strong>mistyped address</strong></li>\n\n          <li>you have <strong>no access</strong> to this page</li>\n          <li>The requested resource was not found.</li>\n          <li>An error has occurred while processing your request.</li>\n        </ol>\n      <p><strong>Please try one of the following pages:</strong></p>\n\n      <p>\n        <ul>\n          <li><a href=\"http://{siteurl}/index.php\" title=\"Go to the Home Page\">Home</a></li>\n        </ul>\n      </p>\n\n      <p>If difficulties persist, please <a href=\"mailto:{sitemail}\">contact</a> the System Administrator of this site.</p>\n\n      <div id=\"techinfo\">\n      <p>{errormessage}</p>\n      </div>\n\n      </div>\n    </div>\n    </div>\n  </div>\n</body>\n</html>', '0', '0000-00-00 00:00:00', '0', '0000-00-00 00:00:00');
