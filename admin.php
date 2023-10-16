<?
require "config.php";

$all_locales = array(
    'aa_DJ' => 'Afar (Djibouti)',
    'aa_ER' => 'Afar (Eritrea)',
    'aa_ET' => 'Afar (Ethiopia)',
    'af_ZA' => 'Afrikaans (South Africa)',
    'sq_AL' => 'Albanian (Albania)',
    'sq_MK' => 'Albanian (Macedonia)',
    'am_ET' => 'Amharic (Ethiopia)',
    'ar_DZ' => 'Arabic (Algeria)',
    'ar_BH' => 'Arabic (Bahrain)',
    'ar_EG' => 'Arabic (Egypt)',
    'ar_IN' => 'Arabic (India)',
    'ar_IQ' => 'Arabic (Iraq)',
    'ar_JO' => 'Arabic (Jordan)',
    'ar_KW' => 'Arabic (Kuwait)',
    'ar_LB' => 'Arabic (Lebanon)',
    'ar_LY' => 'Arabic (Libya)',
    'ar_MA' => 'Arabic (Morocco)',
    'ar_OM' => 'Arabic (Oman)',
    'ar_QA' => 'Arabic (Qatar)',
    'ar_SA' => 'Arabic (Saudi Arabia)',
    'ar_SD' => 'Arabic (Sudan)',
    'ar_SY' => 'Arabic (Syria)',
    'ar_TN' => 'Arabic (Tunisia)',
    'ar_AE' => 'Arabic (United Arab Emirates)',
    'ar_YE' => 'Arabic (Yemen)',
    'an_ES' => 'Aragonese (Spain)',
    'hy_AM' => 'Armenian (Armenia)',
    'as_IN' => 'Assamese (India)',
    'ast_ES' => 'Asturian (Spain)',
    'az_AZ' => 'Azerbaijani (Azerbaijan)',
    'az_TR' => 'Azerbaijani (Turkey)',
    'eu_FR' => 'Basque (France)',
    'eu_ES' => 'Basque (Spain)',
    'be_BY' => 'Belarusian (Belarus)',
    'bem_ZM' => 'Bemba (Zambia)',
    'bn_BD' => 'Bengali (Bangladesh)',
    'bn_IN' => 'Bengali (India)',
    'ber_DZ' => 'Berber (Algeria)',
    'ber_MA' => 'Berber (Morocco)',
    'byn_ER' => 'Blin (Eritrea)',
    'bs_BA' => 'Bosnian (Bosnia and Herzegovina)',
    'br_FR' => 'Breton (France)',
    'bg_BG' => 'Bulgarian (Bulgaria)',
    'my_MM' => 'Burmese (Myanmar [Burma])',
    'ca_AD' => 'Catalan (Andorra)',
    'ca_FR' => 'Catalan (France)',
    'ca_IT' => 'Catalan (Italy)',
    'ca_ES' => 'Catalan (Spain)',
    'zh_CN' => 'Chinese (China)',
    'zh_HK' => 'Chinese (Hong Kong SAR China)',
    'zh_SG' => 'Chinese (Singapore)',
    'zh_TW' => 'Chinese (Taiwan)',
    'cv_RU' => 'Chuvash (Russia)',
    'kw_GB' => 'Cornish (United Kingdom)',
    'crh_UA' => 'Crimean Turkish (Ukraine)',
    'hr_HR' => 'Croatian (Croatia)',
    'cs_CZ' => 'Czech (Czech Republic)',
    'da_DK' => 'Danish (Denmark)',
    'dv_MV' => 'Divehi (Maldives)',
    'nl_AW' => 'Dutch (Aruba)',
    'nl_BE' => 'Dutch (Belgium)',
    'nl_NL' => 'Dutch (Netherlands)',
    'dz_BT' => 'Dzongkha (Bhutan)',
    'en_AG' => 'English (Antigua and Barbuda)',
    'en_AU' => 'English (Australia)',
    'en_BW' => 'English (Botswana)',
    'en_CA' => 'English (Canada)',
    'en_DK' => 'English (Denmark)',
    'en_HK' => 'English (Hong Kong SAR China)',
    'en_IN' => 'English (India)',
    'en_IE' => 'English (Ireland)',
    'en_NZ' => 'English (New Zealand)',
    'en_NG' => 'English (Nigeria)',
    'en_PH' => 'English (Philippines)',
    'en_SG' => 'English (Singapore)',
    'en_ZA' => 'English (South Africa)',
    'en_GB' => 'English (United Kingdom)',
    'en_US' => 'English (United States)',
    'en_ZM' => 'English (Zambia)',
    'en_ZW' => 'English (Zimbabwe)',
    'eo' => 'Esperanto',
    'et_EE' => 'Estonian (Estonia)',
    'fo_FO' => 'Faroese (Faroe Islands)',
    'fil_PH' => 'Filipino (Philippines)',
    'fi_FI' => 'Finnish (Finland)',
    'fr_BE' => 'French (Belgium)',
    'fr_CA' => 'French (Canada)',
    'fr_FR' => 'French (France)',
    'fr_LU' => 'French (Luxembourg)',
    'fr_CH' => 'French (Switzerland)',
    'fur_IT' => 'Friulian (Italy)',
    'ff_SN' => 'Fulah (Senegal)',
    'gl_ES' => 'Galician (Spain)',
    'lg_UG' => 'Ganda (Uganda)',
    'gez_ER' => 'Geez (Eritrea)',
    'gez_ET' => 'Geez (Ethiopia)',
    'ka_GE' => 'Georgian (Georgia)',
    'de_AT' => 'German (Austria)',
    'de_BE' => 'German (Belgium)',
    'de_DE' => 'German (Germany)',
    'de_LI' => 'German (Liechtenstein)',
    'de_LU' => 'German (Luxembourg)',
    'de_CH' => 'German (Switzerland)',
    'el_CY' => 'Greek (Cyprus)',
    'el_GR' => 'Greek (Greece)',
    'gu_IN' => 'Gujarati (India)',
    'ht_HT' => 'Haitian (Haiti)',
    'ha_NG' => 'Hausa (Nigeria)',
    'iw_IL' => 'Hebrew (Israel)',
    'he_IL' => 'Hebrew (Israel)',
    'hi_IN' => 'Hindi (India)',
    'hu_HU' => 'Hungarian (Hungary)',
    'is_IS' => 'Icelandic (Iceland)',
    'ig_NG' => 'Igbo (Nigeria)',
    'id_ID' => 'Indonesian (Indonesia)',
    'ia' => 'Interlingua',
    'iu_CA' => 'Inuktitut (Canada)',
    'ik_CA' => 'Inupiaq (Canada)',
    'ga_IE' => 'Irish (Ireland)',
    'it_IT' => 'Italian (Italy)',
    'it_CH' => 'Italian (Switzerland)',
    'ja_JP' => 'Japanese (Japan)',
    'kl_GL' => 'Kalaallisut (Greenland)',
    'kn_IN' => 'Kannada (India)',
    'ks_IN' => 'Kashmiri (India)',
    'csb_PL' => 'Kashubian (Poland)',
    'kk_KZ' => 'Kazakh (Kazakhstan)',
    'km_KH' => 'Khmer (Cambodia)',
    'rw_RW' => 'Kinyarwanda (Rwanda)',
    'ky_KG' => 'Kirghiz (Kyrgyzstan)',
    'kok_IN' => 'Konkani (India)',
    'ko_KR' => 'Korean (South Korea)',
    'ku_TR' => 'Kurdish (Turkey)',
    'lo_LA' => 'Lao (Laos)',
    'lv_LV' => 'Latvian (Latvia)',
    'li_BE' => 'Limburgish (Belgium)',
    'li_NL' => 'Limburgish (Netherlands)',
    'lt_LT' => 'Lithuanian (Lithuania)',
    'nds_DE' => 'Low German (Germany)',
    'nds_NL' => 'Low German (Netherlands)',
    'mk_MK' => 'Macedonian (Macedonia)',
    'mai_IN' => 'Maithili (India)',
    'mg_MG' => 'Malagasy (Madagascar)',
    'ms_MY' => 'Malay (Malaysia)',
    'ml_IN' => 'Malayalam (India)',
    'mt_MT' => 'Maltese (Malta)',
    'gv_GB' => 'Manx (United Kingdom)',
    'mi_NZ' => 'Maori (New Zealand)',
    'mr_IN' => 'Marathi (India)',
    'mn_MN' => 'Mongolian (Mongolia)',
    'ne_NP' => 'Nepali (Nepal)',
    'se_NO' => 'Northern Sami (Norway)',
    'nso_ZA' => 'Northern Sotho (South Africa)',
    'nb_NO' => 'Norwegian Bokmål (Norway)',
    'nn_NO' => 'Norwegian Nynorsk (Norway)',
    'oc_FR' => 'Occitan (France)',
    'or_IN' => 'Oriya (India)',
    'om_ET' => 'Oromo (Ethiopia)',
    'om_KE' => 'Oromo (Kenya)',
    'os_RU' => 'Ossetic (Russia)',
    'pap_AN' => 'Papiamento (Netherlands Antilles)',
    'ps_AF' => 'Pashto (Afghanistan)',
    'fa_IR' => 'Persian (Iran)',
    'pl_PL' => 'Polish (Poland)',
    'pt_BR' => 'Portuguese (Brazil)',
    'pt_PT' => 'Portuguese (Portugal)',
    'pa_IN' => 'Punjabi (India)',
    'pa_PK' => 'Punjabi (Pakistan)',
    'ro_RO' => 'Romanian (Romania)',
    'ru_RU' => 'Russian (Russia)',
    'ru_UA' => 'Russian (Ukraine)',
    'sa_IN' => 'Sanskrit (India)',
    'sc_IT' => 'Sardinian (Italy)',
    'gd_GB' => 'Scottish Gaelic (United Kingdom)',
    'sr_ME' => 'Serbian (Montenegro)',
    'sr_RS' => 'Serbian (Serbia)',
    'sid_ET' => 'Sidamo (Ethiopia)',
    'sd_IN' => 'Sindhi (India)',
    'si_LK' => 'Sinhala (Sri Lanka)',
    'sk_SK' => 'Slovak (Slovakia)',
    'sl_SI' => 'Slovenian (Slovenia)',
    'so_DJ' => 'Somali (Djibouti)',
    'so_ET' => 'Somali (Ethiopia)',
    'so_KE' => 'Somali (Kenya)',
    'so_SO' => 'Somali (Somalia)',
    'nr_ZA' => 'South Ndebele (South Africa)',
    'st_ZA' => 'Southern Sotho (South Africa)',
    'es_AR' => 'Spanish (Argentina)',
    'es_BO' => 'Spanish (Bolivia)',
    'es_CL' => 'Spanish (Chile)',
    'es_CO' => 'Spanish (Colombia)',
    'es_CR' => 'Spanish (Costa Rica)',
    'es_DO' => 'Spanish (Dominican Republic)',
    'es_EC' => 'Spanish (Ecuador)',
    'es_SV' => 'Spanish (El Salvador)',
    'es_GT' => 'Spanish (Guatemala)',
    'es_HN' => 'Spanish (Honduras)',
    'es_MX' => 'Spanish (Mexico)',
    'es_NI' => 'Spanish (Nicaragua)',
    'es_PA' => 'Spanish (Panama)',
    'es_PY' => 'Spanish (Paraguay)',
    'es_PE' => 'Spanish (Peru)',
    'es_ES' => 'Spanish (Spain)',
    'es_US' => 'Spanish (United States)',
    'es_UY' => 'Spanish (Uruguay)',
    'es_VE' => 'Spanish (Venezuela)',
    'sw_KE' => 'Swahili (Kenya)',
    'sw_TZ' => 'Swahili (Tanzania)',
    'ss_ZA' => 'Swati (South Africa)',
    'sv_FI' => 'Swedish (Finland)',
    'sv_SE' => 'Swedish (Sweden)',
    'tl_PH' => 'Tagalog (Philippines)',
    'tg_TJ' => 'Tajik (Tajikistan)',
    'ta_IN' => 'Tamil (India)',
    'tt_RU' => 'Tatar (Russia)',
    'te_IN' => 'Telugu (India)',
    'th_TH' => 'Thai (Thailand)',
    'bo_CN' => 'Tibetan (China)',
    'bo_IN' => 'Tibetan (India)',
    'tig_ER' => 'Tigre (Eritrea)',
    'ti_ER' => 'Tigrinya (Eritrea)',
    'ti_ET' => 'Tigrinya (Ethiopia)',
    'ts_ZA' => 'Tsonga (South Africa)',
    'tn_ZA' => 'Tswana (South Africa)',
    'tr_CY' => 'Turkish (Cyprus)',
    'tr_TR' => 'Turkish (Turkey)',
    'tk_TM' => 'Turkmen (Turkmenistan)',
    'ug_CN' => 'Uighur (China)',
    'uk_UA' => 'Ukrainian (Ukraine)',
    'hsb_DE' => 'Upper Sorbian (Germany)',
    'ur_PK' => 'Urdu (Pakistan)',
    'uz_UZ' => 'Uzbek (Uzbekistan)',
    've_ZA' => 'Venda (South Africa)',
    'vi_VN' => 'Vietnamese (Vietnam)',
    'wa_BE' => 'Walloon (Belgium)',
    'cy_GB' => 'Welsh (United Kingdom)',
    'fy_DE' => 'Western Frisian (Germany)',
    'fy_NL' => 'Western Frisian (Netherlands)',
    'wo_SN' => 'Wolof (Senegal)',
    'xh_ZA' => 'Xhosa (South Africa)',
    'yi_US' => 'Yiddish (United States)',
    'yo_NG' => 'Yoruba (Nigeria)',
    'zu_ZA' => 'Zulu (South Africa)'
);

$all_timezones = array(
	"Africa/Abidjan",
	"Africa/Accra",
	"Africa/Addis_Ababa",
	"Africa/Algiers",
	"Africa/Asmara",
	"Africa/Asmera",
	"Africa/Bamako",
	"Africa/Bangui",
	"Africa/Banjul",
	"Africa/Bissau",
	"Africa/Blantyre",
	"Africa/Brazzaville",
	"Africa/Bujumbura",
	"Africa/Cairo",
	"Africa/Casablanca",
	"Africa/Ceuta",
	"Africa/Conakry",
	"Africa/Dakar",
	"Africa/Dar_es_Salaam",
	"Africa/Djibouti",
	"Africa/Douala",
	"Africa/El_Aaiun",
	"Africa/Freetown",
	"Africa/Gaborone",
	"Africa/Harare",
	"Africa/Johannesburg",
	"Africa/Juba",
	"Africa/Kampala",
	"Africa/Khartoum",
	"Africa/Kigali",
	"Africa/Kinshasa",
	"Africa/Lagos",
	"Africa/Libreville",
	"Africa/Lome",
	"Africa/Luanda",
	"Africa/Lubumbashi",
	"Africa/Lusaka",
	"Africa/Malabo",
	"Africa/Maputo",
	"Africa/Maseru",
	"Africa/Mbabane",
	"Africa/Mogadishu",
	"Africa/Monrovia",
	"Africa/Nairobi",
	"Africa/Ndjamena",
	"Africa/Niamey",
	"Africa/Nouakchott",
	"Africa/Ouagadougou",
	"Africa/Porto-Novo",
	"Africa/Sao_Tome",
	"Africa/Timbuktu",
	"Africa/Tripoli",
	"Africa/Tunis",
	"Africa/Windhoek",
	"America/Adak",
	"America/Anchorage",
	"America/Anguilla",
	"America/Antigua",
	"America/Araguaina",
	"America/Argentina/Buenos_Aires",
	"America/Argentina/Catamarca",
	"America/Argentina/ComodRivadavia",
	"America/Argentina/Cordoba",
	"America/Argentina/Jujuy",
	"America/Argentina/La_Rioja",
	"America/Argentina/Mendoza",
	"America/Argentina/Rio_Gallegos",
	"America/Argentina/Salta",
	"America/Argentina/San_Juan",
	"America/Argentina/San_Luis",
	"America/Argentina/Tucuman",
	"America/Argentina/Ushuaia",
	"America/Aruba",
	"America/Asuncion",
	"America/Atikokan",
	"America/Atka",
	"America/Bahia",
	"America/Bahia_Banderas",
	"America/Barbados",
	"America/Belem",
	"America/Belize",
	"America/Blanc-Sablon",
	"America/Boa_Vista",
	"America/Bogota",
	"America/Boise",
	"America/Buenos_Aires",
	"America/Cambridge_Bay",
	"America/Campo_Grande",
	"America/Cancun",
	"America/Caracas",
	"America/Catamarca",
	"America/Cayenne",
	"America/Cayman",
	"America/Chicago",
	"America/Chihuahua",
	"America/Coral_Harbour",
	"America/Cordoba",
	"America/Costa_Rica",
	"America/Creston",
	"America/Cuiaba",
	"America/Curacao",
	"America/Danmarkshavn",
	"America/Dawson",
	"America/Dawson_Creek",
	"America/Denver",
	"America/Detroit",
	"America/Dominica",
	"America/Edmonton",
	"America/Eirunepe",
	"America/El_Salvador",
	"America/Ensenada",
	"America/Fort_Nelson",
	"America/Fort_Wayne",
	"America/Fortaleza",
	"America/Glace_Bay",
	"America/Godthab",
	"America/Goose_Bay",
	"America/Grand_Turk",
	"America/Grenada",
	"America/Guadeloupe",
	"America/Guatemala",
	"America/Guayaquil",
	"America/Guyana",
	"America/Halifax",
	"America/Havana",
	"America/Hermosillo",
	"America/Indiana/Indianapolis",
	"America/Indiana/Knox",
	"America/Indiana/Marengo",
	"America/Indiana/Petersburg",
	"America/Indiana/Tell_City",
	"America/Indiana/Vevay",
	"America/Indiana/Vincennes",
	"America/Indiana/Winamac",
	"America/Indianapolis",
	"America/Inuvik",
	"America/Iqaluit",
	"America/Jamaica",
	"America/Jujuy",
	"America/Juneau",
	"America/Kentucky/Louisville",
	"America/Kentucky/Monticello",
	"America/Knox_IN",
	"America/Kralendijk",
	"America/La_Paz",
	"America/Lima",
	"America/Los_Angeles",
	"America/Louisville",
	"America/Lower_Princes",
	"America/Maceio",
	"America/Managua",
	"America/Manaus",
	"America/Marigot",
	"America/Martinique",
	"America/Matamoros",
	"America/Mazatlan",
	"America/Mendoza",
	"America/Menominee",
	"America/Merida",
	"America/Metlakatla",
	"America/Mexico_City",
	"America/Miquelon",
	"America/Moncton",
	"America/Monterrey",
	"America/Montevideo",
	"America/Montreal",
	"America/Montserrat",
	"America/Nassau",
	"America/New_York",
	"America/Nipigon",
	"America/Nome",
	"America/Noronha",
	"America/North_Dakota/Beulah",
	"America/North_Dakota/Center",
	"America/North_Dakota/New_Salem",
	"America/Nuuk",
	"America/Ojinaga",
	"America/Panama",
	"America/Pangnirtung",
	"America/Paramaribo",
	"America/Phoenix",
	"America/Port-au-Prince",
	"America/Port_of_Spain",
	"America/Porto_Acre",
	"America/Porto_Velho",
	"America/Puerto_Rico",
	"America/Punta_Arenas",
	"America/Rainy_River",
	"America/Rankin_Inlet",
	"America/Recife",
	"America/Regina",
	"America/Resolute",
	"America/Rio_Branco",
	"America/Rosario",
	"America/Santa_Isabel",
	"America/Santarem",
	"America/Santiago",
	"America/Santo_Domingo",
	"America/Sao_Paulo",
	"America/Scoresbysund",
	"America/Shiprock",
	"America/Sitka",
	"America/St_Barthelemy",
	"America/St_Johns",
	"America/St_Kitts",
	"America/St_Lucia",
	"America/St_Thomas",
	"America/St_Vincent",
	"America/Swift_Current",
	"America/Tegucigalpa",
	"America/Thule",
	"America/Thunder_Bay",
	"America/Tijuana",
	"America/Toronto",
	"America/Tortola",
	"America/Vancouver",
	"America/Virgin",
	"America/Whitehorse",
	"America/Winnipeg",
	"America/Yakutat",
	"America/Yellowknife",
	"Antarctica/Casey",
	"Antarctica/Davis",
	"Antarctica/DumontDUrville",
	"Antarctica/Macquarie",
	"Antarctica/Mawson",
	"Antarctica/McMurdo",
	"Antarctica/Palmer",
	"Antarctica/Rothera",
	"Antarctica/South_Pole",
	"Antarctica/Syowa",
	"Antarctica/Troll",
	"Antarctica/Vostok",
	"Arctic/Longyearbyen",
	"Asia/Aden",
	"Asia/Almaty",
	"Asia/Amman",
	"Asia/Anadyr",
	"Asia/Aqtau",
	"Asia/Aqtobe",
	"Asia/Ashgabat",
	"Asia/Ashkhabad",
	"Asia/Atyrau",
	"Asia/Baghdad",
	"Asia/Bahrain",
	"Asia/Baku",
	"Asia/Bangkok",
	"Asia/Barnaul",
	"Asia/Beirut",
	"Asia/Bishkek",
	"Asia/Brunei",
	"Asia/Calcutta",
	"Asia/Chita",
	"Asia/Choibalsan",
	"Asia/Chongqing",
	"Asia/Chungking",
	"Asia/Colombo",
	"Asia/Dacca",
	"Asia/Damascus",
	"Asia/Dhaka",
	"Asia/Dili",
	"Asia/Dubai",
	"Asia/Dushanbe",
	"Asia/Famagusta",
	"Asia/Gaza",
	"Asia/Harbin",
	"Asia/Hebron",
	"Asia/Ho_Chi_Minh",
	"Asia/Hong_Kong",
	"Asia/Hovd",
	"Asia/Irkutsk",
	"Asia/Istanbul",
	"Asia/Jakarta",
	"Asia/Jayapura",
	"Asia/Jerusalem",
	"Asia/Kabul",
	"Asia/Kamchatka",
	"Asia/Karachi",
	"Asia/Kashgar",
	"Asia/Kathmandu",
	"Asia/Katmandu",
	"Asia/Khandyga",
	"Asia/Kolkata",
	"Asia/Krasnoyarsk",
	"Asia/Kuala_Lumpur",
	"Asia/Kuching",
	"Asia/Kuwait",
	"Asia/Macao",
	"Asia/Macau",
	"Asia/Magadan",
	"Asia/Makassar",
	"Asia/Manila",
	"Asia/Muscat",
	"Asia/Nicosia",
	"Asia/Novokuznetsk",
	"Asia/Novosibirsk",
	"Asia/Omsk",
	"Asia/Oral",
	"Asia/Phnom_Penh",
	"Asia/Pontianak",
	"Asia/Pyongyang",
	"Asia/Qatar",
	"Asia/Qostanay",
	"Asia/Qyzylorda",
	"Asia/Rangoon",
	"Asia/Riyadh",
	"Asia/Saigon",
	"Asia/Sakhalin",
	"Asia/Samarkand",
	"Asia/Seoul",
	"Asia/Shanghai",
	"Asia/Singapore",
	"Asia/Srednekolymsk",
	"Asia/Taipei",
	"Asia/Tashkent",
	"Asia/Tbilisi",
	"Asia/Tehran",
	"Asia/Tel_Aviv",
	"Asia/Thimbu",
	"Asia/Thimphu",
	"Asia/Tokyo",
	"Asia/Tomsk",
	"Asia/Ujung_Pandang",
	"Asia/Ulaanbaatar",
	"Asia/Ulan_Bator",
	"Asia/Urumqi",
	"Asia/Ust-Nera",
	"Asia/Vientiane",
	"Asia/Vladivostok",
	"Asia/Yakutsk",
	"Asia/Yangon",
	"Asia/Yekaterinburg",
	"Asia/Yerevan",
	"Atlantic/Azores",
	"Atlantic/Bermuda",
	"Atlantic/Canary",
	"Atlantic/Cape_Verde",
	"Atlantic/Faeroe",
	"Atlantic/Faroe",
	"Atlantic/Jan_Mayen",
	"Atlantic/Madeira",
	"Atlantic/Reykjavik",
	"Atlantic/South_Georgia",
	"Atlantic/St_Helena",
	"Atlantic/Stanley",
	"Australia/ACT",
	"Australia/Adelaide",
	"Australia/Brisbane",
	"Australia/Broken_Hill",
	"Australia/Canberra",
	"Australia/Currie",
	"Australia/Darwin",
	"Australia/Eucla",
	"Australia/Hobart",
	"Australia/LHI",
	"Australia/Lindeman",
	"Australia/Lord_Howe",
	"Australia/Melbourne",
	"Australia/North",
	"Australia/NSW",
	"Australia/Perth",
	"Australia/Queensland",
	"Australia/South",
	"Australia/Sydney",
	"Australia/Tasmania",
	"Australia/Victoria",
	"Australia/West",
	"Australia/Yancowinna",
	"Brazil/Acre",
	"Brazil/DeNoronha",
	"Brazil/East",
	"Brazil/West",
	"Canada/Atlantic",
	"Canada/Central",
	"Canada/Eastern",
	"Canada/Mountain",
	"Canada/Newfoundland",
	"Canada/Pacific",
	"Canada/Saskatchewan",
	"Canada/Yukon",
	"CET",
	"Chile/Continental",
	"Chile/EasterIsland",
	"CST6CDT",
	"Cuba",
	"EET",
	"Egypt",
	"Eire",
	"EST",
	"EST5EDT",
	"Etc/GMT",
	"Etc/GMT+0",
	"Etc/GMT+1",
	"Etc/GMT+10",
	"Etc/GMT+11",
	"Etc/GMT+12",
	"Etc/GMT+2",
	"Etc/GMT+3",
	"Etc/GMT+4",
	"Etc/GMT+5",
	"Etc/GMT+6",
	"Etc/GMT+7",
	"Etc/GMT+8",
	"Etc/GMT+9",
	"Etc/GMT-0",
	"Etc/GMT-1",
	"Etc/GMT-10",
	"Etc/GMT-11",
	"Etc/GMT-12",
	"Etc/GMT-13",
	"Etc/GMT-14",
	"Etc/GMT-2",
	"Etc/GMT-3",
	"Etc/GMT-4",
	"Etc/GMT-5",
	"Etc/GMT-6",
	"Etc/GMT-7",
	"Etc/GMT-8",
	"Etc/GMT-9",
	"Etc/GMT0",
	"Etc/Greenwich",
	"Etc/UCT",
	"Etc/Universal",
	"Etc/UTC",
	"Etc/Zulu",
	"Europe/Amsterdam",
	"Europe/Andorra",
	"Europe/Astrakhan",
	"Europe/Athens",
	"Europe/Belfast",
	"Europe/Belgrade",
	"Europe/Berlin",
	"Europe/Bratislava",
	"Europe/Brussels",
	"Europe/Bucharest",
	"Europe/Budapest",
	"Europe/Busingen",
	"Europe/Chisinau",
	"Europe/Copenhagen",
	"Europe/Dublin",
	"Europe/Gibraltar",
	"Europe/Guernsey",
	"Europe/Helsinki",
	"Europe/Isle_of_Man",
	"Europe/Istanbul",
	"Europe/Jersey",
	"Europe/Kaliningrad",
	"Europe/Kiev",
	"Europe/Kirov",
	"Europe/Lisbon",
	"Europe/Ljubljana",
	"Europe/London",
	"Europe/Luxembourg",
	"Europe/Madrid",
	"Europe/Malta",
	"Europe/Mariehamn",
	"Europe/Minsk",
	"Europe/Monaco",
	"Europe/Moscow",
	"Europe/Nicosia",
	"Europe/Oslo",
	"Europe/Paris",
	"Europe/Podgorica",
	"Europe/Prague",
	"Europe/Riga",
	"Europe/Rome",
	"Europe/Samara",
	"Europe/San_Marino",
	"Europe/Sarajevo",
	"Europe/Saratov",
	"Europe/Simferopol",
	"Europe/Skopje",
	"Europe/Sofia",
	"Europe/Stockholm",
	"Europe/Tallinn",
	"Europe/Tirane",
	"Europe/Tiraspol",
	"Europe/Ulyanovsk",
	"Europe/Uzhgorod",
	"Europe/Vaduz",
	"Europe/Vatican",
	"Europe/Vienna",
	"Europe/Vilnius",
	"Europe/Volgograd",
	"Europe/Warsaw",
	"Europe/Zagreb",
	"Europe/Zaporozhye",
	"Europe/Zurich",
	"Factory",
	"GB",
	"GB-Eire",
	"GMT",
	"GMT+0",
	"GMT-0",
	"GMT0",
	"Greenwich",
	"Hongkong",
	"HST",
	"Iceland",
	"Indian/Antananarivo",
	"Indian/Chagos",
	"Indian/Christmas",
	"Indian/Cocos",
	"Indian/Comoro",
	"Indian/Kerguelen",
	"Indian/Mahe",
	"Indian/Maldives",
	"Indian/Mauritius",
	"Indian/Mayotte",
	"Indian/Reunion",
	"Iran",
	"Israel",
	"Jamaica",
	"Japan",
	"Kwajalein",
	"Libya",
	"MET",
	"Mexico/BajaNorte",
	"Mexico/BajaSur",
	"Mexico/General",
	"MST",
	"MST7MDT",
	"Navajo",
	"NZ",
	"NZ-CHAT",
	"Pacific/Apia",
	"Pacific/Auckland",
	"Pacific/Bougainville",
	"Pacific/Chatham",
	"Pacific/Chuuk",
	"Pacific/Easter",
	"Pacific/Efate",
	"Pacific/Enderbury",
	"Pacific/Fakaofo",
	"Pacific/Fiji",
	"Pacific/Funafuti",
	"Pacific/Galapagos",
	"Pacific/Gambier",
	"Pacific/Guadalcanal",
	"Pacific/Guam",
	"Pacific/Honolulu",
	"Pacific/Johnston",
	"Pacific/Kiritimati",
	"Pacific/Kosrae",
	"Pacific/Kwajalein",
	"Pacific/Majuro",
	"Pacific/Marquesas",
	"Pacific/Midway",
	"Pacific/Nauru",
	"Pacific/Niue",
	"Pacific/Norfolk",
	"Pacific/Noumea",
	"Pacific/Pago_Pago",
	"Pacific/Palau",
	"Pacific/Pitcairn",
	"Pacific/Pohnpei",
	"Pacific/Ponape",
	"Pacific/Port_Moresby",
	"Pacific/Rarotonga",
	"Pacific/Saipan",
	"Pacific/Samoa",
	"Pacific/Tahiti",
	"Pacific/Tarawa",
	"Pacific/Tongatapu",
	"Pacific/Truk",
	"Pacific/Wake",
	"Pacific/Wallis",
	"Pacific/Yap",
	"Poland",
	"Portugal",
	"PRC",
	"PST8PDT",
	"ROC",
	"ROK",
	"Singapore",
	"Turkey",
	"UCT",
	"Universal",
	"US/Alaska",
	"US/Aleutian",
	"US/Arizona",
	"US/Central",
	"US/East-Indiana",
	"US/Eastern",
	"US/Hawaii",
	"US/Indiana-Starke",
	"US/Michigan",
	"US/Mountain",
	"US/Pacific",
	"US/Samoa",
	"UTC",
	"W-SU",
	"WET",
	"Zulu",
);
?>
<!DOCTYPE HTML>
<html class="no-js">
<head>
	<title>Survey management. Admin</title>
	<meta name="keywords" content="">
	<meta name="description" content="">
	<meta name="robots" content="index, follow">
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="imagetoolbar" content="no">
	<meta name="msthemecompatible" content="no">
	<meta name="cleartype" content="on">
	<meta name="HandheldFriendly" content="True">
	<link rel="icon" type="image/png" href="favicon.png" />
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="app.css">
	<link rel="stylesheet" href="datepicker.min.css">
</head>
<body>
<?
$log = "";
$pass = "";
if (@$_POST["login"] != "" && @$_POST["passwrd"] != "")
	{
	$_SESSION["s_login"] = @$_POST["login"];
	$_SESSION["s_password"] = md5(@$_POST["passwrd"]);
}
if (@$_SESSION["s_login"] != $log || @$_SESSION["s_password"] != md5($pass))
	{
	if (@$_SESSION["index_msg"] != "")
		print "<div class=\"login_error\">".$_SESSION["index_msg"]."</div>";
	$_SESSION["index_msg"] = "";
	?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-4"></div>
			<div class="col-4">
				<form class="text-center border border-light p-5" method="post" action="/admin.php">
				<h1>Users management login</h1>
				<div class="group">
					<div class="login_ttl">Login:</div>
					<div class="login_fld"><input type="text" name="login" size="20" /></div>
				</div>
				<div class="group">
					<div class="login_ttl">Password:</div>
					<div class="login_fld"><input type="password" name="passwrd" size="20" /></div>
				</div>
				<div class="login_enter"><button class="btn btn-info btn-block my-4 waves-effect waves-light" type="submit" name="submitit">enter</button></div>
				</form>
			</div>
			<div class="col-4"></div>
		</div>
	</div>
	<?
	if (@$_POST["login"] != "" || @$_POST["passwrd"] != "")
		{
		?>
		<div class="alert alert-warning" role="alert" style="display: block;">
			<strong id="messages">Wrong login or password</strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<?
	}
	?>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<?
}
else
	{
	?>
	<section class="container-fluid users_container">
		<div class="alert alert-success" role="alert">
			<strong id="messages"></strong>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			<span aria-hidden="true">&times;</span>
			</button>
		</div>
		<div class="row">
			<div class="col-6">
				<div class="row">
					<div class="col-12">
						<h1>Users management (<a href="xp_exit_admin.php">exit</a>)</h1>
						<h4>Users list</h4>
						<div id="user_list">
							<?
							$q = mysql_query("select * from users");
							while($arr = mysql_fetch_assoc($q))
								{
								?>
								<div class="user_item" data-uid="<?=$arr["user_id"];?>">
									<span class="user_name_login"><?=$arr["user_name"];?> (<?=$arr["user_login"];?>)</span>
									<button type="button" class="close js-edit" data-id="<?=$arr["user_id"];?>"><span aria-hidden="true">&#x270E;</span></button>
									<button type="button" class="close js-deluser" data-id="<?=$arr["user_id"];?>" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								</div>
								<?
							}
							if (mysql_num_rows($q) == 0)
								{
								?>
								<div class="no_users">
									No users found
								</div>
								<?
							}
							?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						<button class="btn btn-primary" onClick="action = 'ADD'; $('#add_update').text('Add new user'); $('#users')[0].reset(); $('#user_add').slideToggle(300);$('.userId').fadeOut(300);">Show/hide add new user form</button>
					</div>
				</div>
				<div class="row hidden" id="user_add">
					<div class="col-12">
						<form id="users">
							<br />
							<div class="form-group row userId" style="display:none">
								<label for="user_id" class="col-4">userId:</label>
								<input class="form-control col-4" name="user_id" id="user_id" value="" readonly />
								<div class="invalid-feedback col-4" id="user_id_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="user_name" class="col-4">User Name:</label>
								<input class="form-control col-4" name="user_name" id="user_name" value="" required />
								<div class="invalid-feedback col-4" id="user_name_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="user_login" class="col-4">User login:</label>
								<input class="form-control col-4" name="user_login" id="user_login" value="" required />
								<div class="invalid-feedback col-4" id="user_login_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="user_url" class="col-4">User url:</label>
								<input class="form-control col-4" name="user_url" id="user_url" value="" required />
								<div class="invalid-feedback col-4" id="user_url_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="user_password" class="col-4">User password:</label>
								<input class="form-control col-4" type="password" name="user_password" id="user_password" value="" required />
								<div class="invalid-feedback col-4" id="user_password_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="q_token" class="col-4">Qualtrics token:</label>
								<input class="form-control col-4" name="q_token" id="q_token" value="" required />
								<div class="invalid-feedback col-4" id="q_token_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="ph_username" class="col-4">Phonic user_name:</label>
								<input class="form-control col-4" name="ph_username" id="ph_username" value="" />
								<div class="invalid-feedback col-4" id="ph_username_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="ph_password" class="col-4">Phonic password:</label>
								<input class="form-control col-4" name="ph_password" id="ph_password" value="" />
								<div class="invalid-feedback col-4" id="ph_password_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="phys_username" class="col-4">Physioq user_name:</label>
								<input class="form-control col-4" name="phys_username" id="phys_username" value="" />
								<div class="invalid-feedback col-4" id="phys_username_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="phys_password" class="col-4">Physioq password:</label>
								<input class="form-control col-4" name="phys_password" id="phys_password" value="" />
								<div class="invalid-feedback col-4" id="phys_password_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="phys_root" class="col-4">Physioq root folder:</label>
								<input class="form-control col-4" name="phys_root" id="phys_root" value="" />
								<div class="invalid-feedback col-4" id="phys_root_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="locale" class="col-4">Default timezone:</label>
								<select class="form-control col-4" name="locale" id="locale">
								<?
								foreach($all_timezones as $timezone)
								{
								?>
								<option value="<?=$timezone;?>"><?=$timezone;?></option>
								<?
								}
								?>
								</select>
								<div class="invalid-feedback col-4" id="locale_feedback"></div>
							</div>
							<div class="form-group row">
								<label for="tinyurl" class="col-4">Tiny URL make service:</label>
								<input class="form-control col-4" name="tinyurl" id="tinyurl" value="" />
								<div class="invalid-feedback col-4" id="tinyurl_feedback"></div>
							</div>
							<div class="form-group form-row">
								<button type="submit" id="add_update" class="btn btn-primary">Add new user</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-6">
				<h2>SMS and WhatsApp messages</h2>
				<div class="wams">
				<?
				$q = mysql_query("select * from wa_messages") or die(mysql_error());
				while ($arr = mysql_fetch_assoc($q))
					{
					?>
					<div class="wam wam<?=$arr["wam_id"];?>"><?=$arr["wam_name"];?> <button type="button" class="close js-delwam" data-id="<?=$arr["wam_id"];?>" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>
					<div class="wam_self"><?=$arr["wam"];?></div>
					<?
				}
				?>
				</div>
				<br /><br />
				<form id="wams">
					<h3>Adding new SMS or WhatsApp message</h3>
					<br />
					<div class="form-group row">
						<label for="wam_name" class="col-4">Message name:</label>
						<input class="form-control col-4" name="wam_name" id="wam_name" value="" required />
						<div class="invalid-feedback col-4" id="wam_name_feedback"></div>
					</div>
					<div class="form-group row">
						<label for="wam" class="col-4">Message:</label>
						<textarea class="form-control col-4" name="wam" id="wam" required></textarea>
						<div class="invalid-feedback col-4" id="wam_feedback"></div>
					</div>
					<div class="form-group form-row">
						<button type="submit" id="add_wam" class="btn btn-primary">Add new message</button>
					</div>
				</form>
			</div>
		</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
	<script src="jquery.inputmask.min.js"></script>
	<script>
	var action = "ADD";
	var wams = [];
	$(document).ready(function () {
		$.ajax({
			"async": true,
			"url": "xp_ajax.php",
			"method": "POST",
			"timeout": 125000,
			"dataType": "json",
			"data": "method=GET&action=wams",
		}).done(function(response) {
			// console.table(response);
			if (response != null && typeof response.result != "undefined") {
				wams = response.result.elements;
				console.table(wams);
				// let slct = document.getElementById('wa_message');
				// let slct1 = document.getElementById('wa_rmessage');
				// slct.options.length = 1;
				// slct1.options.length = 1;
				// $.each(response.result.elements, function(index, value) {
					// var opt = document.createElement("option");
					// opt.value = value.wam_id;
					// opt.innerHTML = value.wam_name;
					// slct.appendChild(opt);
					// var opt = document.createElement("option");
					// opt.value = value.wam_id;
					// opt.innerHTML = value.wam_name;
					// slct1.appendChild(opt);
				// });
			}
		}).fail(function(jqXHR, textStatus) {
			// console.log(textStatus);
			showAlert("warning", textStatus);
		});
		$(document).on("click", ".js-addwam", function(event) {
			$(".mask").fadeIn(300);
			$(".wams_add").fadeIn(300);
		});
		$(document).on("click", ".js-delwam", function(event) {
			let id = $(this).data("id");
			if (confirm("Are you sure you want to delete this message?")) {
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 25000,
					"dataType": "json",
					"data": "action=wams&method=DELETE&id=" + id,
				}).done(function(response) {
					$("option[value=" + id + "]").remove();
					$(".wam" + id).remove();
				}).fail(function(jqXHR, textStatus) {
					alert("Error deleting message");
				});
			}
		});
		$("#wams").submit(function(e) {
			e.preventDefault();
			let data = $("#wams").serialize();
			if (chkFields2()) {
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 25000,
					"dataType": "json",
					"data": "action=wams&method=ADD&data=" + encodeURIComponent(data),
				}).done(function(response) {
					if (typeof response.error != "undefined" && response.error != "")
						alert(response.error);
					else {
						var id = response.id;
						var wam_name = decodeURI(response.wam_name);
						var wam = response.wam;
						wams[id] = {wam_name: wam_name, wam: wam};
						var html = "<div class=\"wam wam" + id + "\">" + wam_name + " <button type=\"button\" class=\"close js-delwam\" data-id=\"" + id + "\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>";
						$(".wams").append(html);
						console.table(wams);
						// let slct = document.getElementById('wa_message');
						// let slct1 = document.getElementById('wa_rmessage');
						// var opt = document.createElement("option");
						// opt.value = id;
						// opt.innerHTML = wam_name;
						// slct.appendChild(opt);
						// var opt = document.createElement("option");
						// opt.value = id;
						// opt.innerHTML = wam_name;
						// slct1.appendChild(opt);
						$(".mask").fadeOut(300);
						$(".wams_add").fadeOut(300);
					}
				}).fail(function(jqXHR, textStatus) {
					alert("Error adding message");
				});
			}
		});
		$("#users").submit(function(e) {
			e.preventDefault();
			if (chkFields1()) {
				let data = $("#users").serialize();
				$("#user_add").slideUp(300);
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 25000,
					"dataType": "json",
					"data": "action=user&method=" + action + "&data=" + encodeURIComponent(data),
				}).done(function(response) {
					// $("#user_add").slideDown(300);
					if (typeof response.error != "undefined" && response.error != "")
						alert(response.error);
					else {
						var id = response.id;
						var name = response.name;
						var login = response.login;
						if (action == "ADD") {
							var html = "<div class=\"user_item\" data-uid=\"" + id + "\"><span class=\"user_name_login\">" + name + " (" + login + ")</span> <button type=\"button\" class=\"close js-edit\" data-id=\"" + id + "\"><span aria-hidden=\"true\">&#x270E;</span></button> <button type=\"button\" class=\"close js-deluser\" data-id=\"" + id + "\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button></div>"
							$("#user_list").append(html);
						}
						else {
							$("[data-uid=" + id + "]").find(".user_name_login").html(name + " (" + login + ")");
						}
						$(".no_users").fadeOut();
					}
				}).fail(function(jqXHR, textStatus) {
					alert("Error adding user");
				});
			}
		});
		$(document).on("click", ".js-edit", function(event) {
			if (confirm("Are you sure that you want to edit this user?")) {
				let id = $(this).data("id");
				action = "UPDATE";
				$("#user_id").val(id);
				$(".userId").fadeIn(300);
				$("#user_add").slideDown(300);
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 25000,
					"dataType": "json",
					"data": "action=user&method=GET&id=" + id,
				}).done(function(response) {
					$("#user_name").val(response.user_name);
					$("#user_login").val(response.user_login);
					$("#user_password").removeAttr("required");
					$("#user_url").val(response.user_url);
					$("#q_token").val(response.q_token);
					$("#ph_username").val(response.ph_username);
					$("#ph_password").val(response.ph_password);
					$("#phys_username").val(response.phys_username);
					$("#phys_password").val(response.phys_password);
					$("#phys_root").val(response.phys_root);
					$("#tinyurl").val(response.tinyurl);
					if (response.locale != null && response.locale != "")
						$("#locale").val(response.locale);
					else
						$("#locale").val("Asia/Jerusalem",);
					$("#wa_message").val(response.wa_message);
					$("#wa_rmessage").val(response.wa_rmessage);
					$("#add_update").text("Update user");				
				}).fail(function(jqXHR, textStatus) {
					alert("Error getting user");
				});
			}
		});
		$(document).on("click", ".js-deluser", function(event) {
			if (prompt("Are you sure you want to delete user «" + name + "» and all his data?\n\rEnter admin password:") == '<?=$pass;?>') {
				let id = $(this).data("id");
				$.ajax({
					"async": true,
					"url": "xp_ajax.php",
					"method": "POST",
					"timeout": 25000,
					"dataType": "json",
					"data": "action=user&method=DELETE&id=" + id,
				}).done(function(response) {
					$("[data-uid=" + id + "]").fadeOut(300);
				}).fail(function(jqXHR, textStatus) {
					alert("Error deleting user");
				});
			}
		});
	});
	function chkFields1() {
		let flag = true;
		$("#users").find('input').each(function () {
			$(this).removeClass('is-invalid');
			$(this).parent().find(".invalid-feedback").text("");
			if ($(this).attr("id") == "user_login" && $(this).val() == "admin") {
				$(this).addClass('is-invalid');
				$(this).parent().find(".invalid-feedback").text("User login cannot be «admin»");
				flag = false;
			}
			if ($(this).attr('required') == 'required' && $(this).val() == '') {
				$(this).addClass('is-invalid');
				$(this).parent().find(".invalid-feedback").text("Cannot be empty");
				flag = false;
			}
		});
		return flag;
	}
	function chkFields2() {
		let flag = true;
		$("#wams").find('input').each(function () {
			$(this).removeClass('is-invalid');
			$(this).parent().find(".invalid-feedback").text("");
			if ($(this).attr("id") == "user_login" && $(this).val() == "admin") {
				$(this).addClass('is-invalid');
				$(this).parent().find(".invalid-feedback").text("User login cannot be «admin»");
				flag = false;
			}
			if ($(this).attr('required') == 'required' && $(this).val() == '') {
				$(this).addClass('is-invalid');
				$(this).parent().find(".invalid-feedback").text("Cannot be empty");
				flag = false;
			}
		});
		return flag;
	}
	function showAlert(state, msg, rel = 0) {
		$(".alert").fadeOut(300).promise().done(function() {
			$("#messages").append(msg + "<br />");
			$("#all_popups").append(msg + "<br />");
			$(".alert").removeClass("alert-warning").removeClass("alert-success").removeClass("alert-danger").removeClass("alert-info").addClass("alert-" + state).fadeIn(300).promise().done(function() {
				setTimeout(function() {
					$(".alert").fadeOut(300);
					if (rel == 1)
						location.reload();
				}, 5000);
				setTimeout(function() {
					$("#messages").html("");
				}, 10000);
			});
		});
	}
	</script>
	<?
}
?>
</body>
</html>