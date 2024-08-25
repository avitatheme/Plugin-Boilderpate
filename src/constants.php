<?php

namespace vnh_namespace;

define(__NAMESPACE__ . '\PLUGIN_DATA', get_plugin_data(PLUGIN_FILE));
define(__NAMESPACE__ . '\PLUGIN_SLUG', basename(PLUGIN_DIR));
define(__NAMESPACE__ . '\PLUGIN_BASE', plugin_basename(PLUGIN_FILE));
define(__NAMESPACE__ . '\PLUGIN_DOCUMENT_URI', get_file_data(PLUGIN_FILE, ['Document URI'])[0]);
define(__NAMESPACE__ . '\MIN_WC_VERSION', get_file_data(PLUGIN_FILE, ['WC requires at least'])[0]);

const PLUGIN_NAME = PLUGIN_DATA['Name'];
const PLUGIN_DESCRIPTION = PLUGIN_DATA['Description'];
const PLUGIN_URI = PLUGIN_DATA['PluginURI'];
const PLUGIN_VERSION = PLUGIN_DATA['Version'];
const PLUGIN_AUTHOR = PLUGIN_DATA['Author'];
const PLUGIN_AUTHOR_URI = PLUGIN_DATA['AuthorURI'];
const PLUGIN_TEXT_DOMAIN = PLUGIN_DATA['TextDomain'];

const DS = '/';
const MIN_PHP_VERSION = 7.0;
const MIN_WP_VERSION = 5.0;
