<?php
class ApplyCard {
    static $arParam = array();

    static function param($item, $get = array()){
        switch($item){
            case 1:
                $param['keyPost'] = array(
                    'last_name',
                    'first_name',
                    'middle_name',
                    'is_records_name',
                    'last_name_records',
                    'first_name_records',
                    'middle_name_records',
                    'gender',
                    'date_mm',
                    'date_dd',
                    'date_yyyy',
                    'phone',
                    'email',
                    'cell_phone',
                    'about_us',
                    'about_us_answer',
                    'country',
                    'services_WCES',
                    'old_num_card',
                    'addressOneLine',
                    'addressTwoLine',
                    'city',
                    'region',
                    'postal_code',
                    'zip_code',
                    'state'
                );

                $param['is_records_name'] = array(
                    0 => '',
                    1 => 'No',
                    2 => 'Yes'
                );

                $param['gender'] = array(
                    0 => '',
                    1 => 'Male',
                    2 => 'Female'
                );

                $param['about_us'] = array(
                    '0' => '',
                    '1' => 'Educational Institution',
                    '2' => 'Friend',
                    '3' => 'Recruiter',
                    '4' => 'Internet',
                    '5' => 'Advertisement',
                    '6' => 'Employer',
                    '7' => 'Other'
                );

                $param['services_WCES'] = array(
                    0 => '',
                    1 => 'No',
                    2 => 'Yes'
                );
                break;

            case 2:
                $param['keyPost'] = array(
                    'add_history',
                    'country_study',
                    'city',
                    'name_institution',
                    'date_mm_from',
                    'date_yyyy_from',
                    'date_mm_to',
                    'date_yyyy_to',
                    'diploma_name',
                    'reason_text',
                    'fileScan'
                );
                break;

            case 3:
                $param['keyPost'] = array(
                    'main_purpose',
                    'please_spec',
                    'admission_to',
                    'document_requirements',
                    'report_type',
                    'admission_ap_pur'
                );

                $param['main_purpose'] = array(
                    0 => 'Choose one...',
                    1 => 'Education',
                    2 => 'Employment / Salary Adjustment',
                    3 => 'Immigration',
                    4 => 'Other'
                );

                $param['admission_to'] = array(
                    1 => 'High School',
                    2 => 'Junior / Community College',
                    3 => 'University (undergraduate)',
                    4 => 'University (graduate)',
                    5 => 'Other'
                );

                $param['document_requirements'] = array(
                    0 => '',
                    1 => 'No',
                    2 => 'Yes'
                );

                $param['report_type'] = array(
                    1 => array(
                        'name'   => 'General Report',
                        'price'  => '75',
                        'sample' => '#'
                    ),
                    2 => array(
                        'name'   => 'Detail Report',
                        'price'  => '100',
                        'sample' => '#'
                    ),
                    3 => array(
                        'name'   => 'Detail Report with Course Level Identification',
                        'price'  => '125',
                        'sample' => '#'
                    )
                );

                $param['admission_ap_pur'] = array(
                    1 => 'Education',
                    2 => 'Employment / Salary Adjustment',
                    3 => 'Immigration',
                    4 => 'Other'
                );

                $param['report_type_text'] = array(
                    1 => 'Unless otherwise instructed by your institution, we recommend that you select a Detail Report with Course Level Identification.',
                    2 => 'Unless otherwise instructed by your employer (or potential employer), we recommend that you select a General Report.',
                    3 => 'Unless otherwise instructed by USCIS or your employer, we recommend that you select a General Report.',
                    4 => 'Unless otherwise instructed by your institution, we recommend that you select a Detail Report with Course Level Identification.'
                );
                break;

            case 4:
                $param['keyPost'] = array(
                    'applicant_copy',
                    'ap_institution',
                    'ap_attention_to',
                    'ap_department',
                    'ap_address1',
                    'ap_address2',
                    'ap_city',
                    'ap_phone',
                    'ap_country',
                    'ap_state',
                    'ap_zip_code',
                    'ap_region',
                    'ap_postal_code',
                    'ap_mailing',
                    'ap_liability'
                );

                $param['applicant_copy'] = array(
                    0 => '',
                    1 => 'US-Address',
                    2 => 'Non US-Address'
                );

                $param['ap_mailing_us'] = array(
                    1 => array(
                        'text'  => 'Regular Mail',
                        'price' => '0'
                    ),
                    2 => array(
                        'text'  => 'Domestic Secure Mailing',
                        'price' => '15'
                    ),
                    3 => array(
                        'text'  => 'Domestic Next Day Delivery',
                        'price' => '20'
                    )
                );

                $param['ap_mailing_all'] = array(
                    1 => array(
                        'text'  => 'Regular Mail',
                        'price' => '20'
                    ),
                    2 => array(
                        'text'  => 'Domestic Secure Mailing',
                        'price' => '65'
                    ),
                    3 => array(
                        'text'  => 'Domestic Next Day Delivery',
                        'price' => '125'
                    )
                );

                $param['mailing_copy'] = array(
                    1 => array(
                        'text'  => 'Regular Mail',
                        'price' => '0'
                    ),
                    2 => array(
                        'text'  => 'Domestic Secure Mailing',
                        'price' => '15'
                    ),
                    3 => array(
                        'text'  => 'Domestic Next Day Delivery',
                        'price' => '20'
                    )
                );
                break;

            case 5:
                $param['keyPost'] = array(
                    'turnaround_time'
                );

                $param['turnaround_time'] = array(
                    1 => array(
                        'text'  => '5-Day Rush *',
                        'price' => '0',
                    ),
                    2 => array(
                        'text'  => '24-Hour Rush',
                        'price' => '125',
                    ),
                );
                break;

            case 6:
                $param['keyPost'] = array(
                    'end_comment'
                );
                break;

            case 'glob':
                $param['date_mm'] = $param['date_mm_from'] = $param['date_mm_to'] = array(
                    '0'  => '',
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12'
                );

                $param['date_dd'] = array(
                    '0'  => '',
                    '01' => '01',
                    '02' => '02',
                    '03' => '03',
                    '04' => '04',
                    '05' => '05',
                    '06' => '06',
                    '07' => '07',
                    '08' => '08',
                    '09' => '09',
                    '10' => '10',
                    '11' => '11',
                    '12' => '12',
                    '13' => '13',
                    '14' => '14',
                    '15' => '15',
                    '16' => '16',
                    '17' => '17',
                    '18' => '18',
                    '19' => '19',
                    '20' => '20',
                    '21' => '21',
                    '22' => '22',
                    '23' => '23',
                    '24' => '24',
                    '25' => '25',
                    '26' => '26',
                    '27' => '27',
                    '28' => '28',
                    '29' => '29',
                    '30' => '30',
                    '31' => '31'
                );

                $param['date_yyyy'] = array(
                    '0'    => '',
                    '1916' => '1916',
                    '1917' => '1917',
                    '1918' => '1918',
                    '1919' => '1919',
                    '1920' => '1920',
                    '1921' => '1921',
                    '1922' => '1922',
                    '1923' => '1923',
                    '1924' => '1924',
                    '1925' => '1925',
                    '1926' => '1926',
                    '1927' => '1927',
                    '1928' => '1928',
                    '1929' => '1929',
                    '1930' => '1930',
                    '1931' => '1931',
                    '1932' => '1932',
                    '1933' => '1933',
                    '1934' => '1934',
                    '1935' => '1935',
                    '1936' => '1936',
                    '1937' => '1937',
                    '1938' => '1938',
                    '1939' => '1939',
                    '1940' => '1940',
                    '1941' => '1941',
                    '1942' => '1942',
                    '1943' => '1943',
                    '1944' => '1944',
                    '1945' => '1945',
                    '1946' => '1946',
                    '1947' => '1947',
                    '1948' => '1948',
                    '1949' => '1949',
                    '1950' => '1950',
                    '1951' => '1951',
                    '1952' => '1952',
                    '1953' => '1953',
                    '1954' => '1954',
                    '1955' => '1955',
                    '1956' => '1956',
                    '1957' => '1957',
                    '1958' => '1958',
                    '1959' => '1959',
                    '1960' => '1960',
                    '1961' => '1961',
                    '1962' => '1962',
                    '1963' => '1963',
                    '1964' => '1964',
                    '1965' => '1965',
                    '1966' => '1966',
                    '1967' => '1967',
                    '1968' => '1968',
                    '1969' => '1969',
                    '1970' => '1970',
                    '1971' => '1971',
                    '1972' => '1972',
                    '1973' => '1973',
                    '1974' => '1974',
                    '1975' => '1975',
                    '1976' => '1976',
                    '1977' => '1977',
                    '1978' => '1978',
                    '1979' => '1979',
                    '1980' => '1980',
                    '1981' => '1981',
                    '1982' => '1982',
                    '1983' => '1983',
                    '1984' => '1984',
                    '1985' => '1985',
                    '1986' => '1986',
                    '1987' => '1987',
                    '1988' => '1988',
                    '1989' => '1989',
                    '1990' => '1990',
                    '1991' => '1991',
                    '1992' => '1992',
                    '1993' => '1993',
                    '1994' => '1994',
                    '1995' => '1995',
                    '1996' => '1996',
                    '1997' => '1997',
                    '1998' => '1998',
                    '1999' => '1999',
                    '2000' => '2000',
                    '2001' => '2001',
                    '2002' => '2002',
                    '2003' => '2003',
                    '2004' => '2004',
                    '2005' => '2005',
                    '2006' => '2006',
                    '2007' => '2007'
                );

                $param['date_yyyy_from'] = $param['date_yyyy_to'] = array(
                    ''     => '',
                    '2016' => '2016',
                    '2015' => '2015',
                    '2014' => '2014',
                    '2013' => '2013',
                    '2012' => '2012',
                    '2011' => '2011',
                    '2010' => '2010',
                    '2009' => '2009',
                    '2008' => '2008',
                    '2007' => '2007',
                    '2006' => '2006',
                    '2005' => '2005',
                    '2004' => '2004',
                    '2003' => '2003',
                    '2002' => '2002',
                    '2001' => '2001',
                    '2000' => '2000',
                    '1999' => '1999',
                    '1998' => '1998',
                    '1997' => '1997',
                    '1996' => '1996',
                    '1995' => '1995',
                    '1994' => '1994',
                    '1993' => '1993',
                    '1992' => '1992',
                    '1991' => '1991',
                    '1990' => '1990',
                    '1989' => '1989',
                    '1988' => '1988',
                    '1987' => '1987',
                    '1986' => '1986',
                    '1985' => '1985',
                    '1984' => '1984',
                    '1983' => '1983',
                    '1982' => '1982',
                    '1981' => '1981',
                    '1980' => '1980',
                    '1979' => '1979',
                    '1978' => '1978',
                    '1977' => '1977',
                    '1976' => '1976',
                    '1975' => '1975',
                    '1974' => '1974',
                    '1973' => '1973',
                    '1972' => '1972',
                    '1971' => '1971',
                    '1970' => '1970',
                    '1969' => '1969',
                    '1968' => '1968',
                    '1967' => '1967',
                    '1966' => '1966',
                    '1965' => '1965',
                    '1964' => '1964',
                    '1963' => '1963',
                    '1962' => '1962',
                    '1961' => '1961',
                    '1960' => '1960',
                    '1959' => '1959',
                    '1958' => '1958',
                    '1957' => '1957',
                    '1956' => '1956',
                    '1955' => '1955',
                    '1954' => '1954',
                    '1953' => '1953',
                    '1952' => '1952',
                    '1951' => '1951',
                    '1950' => '1950',
                    '1949' => '1949',
                    '1948' => '1948',
                    '1947' => '1947',
                    '1946' => '1946',
                    '1945' => '1945',
                    '1944' => '1944',
                    '1943' => '1943',
                    '1942' => '1942',
                    '1941' => '1941',
                    '1940' => '1940',
                    '1939' => '1939',
                    '1938' => '1938',
                    '1937' => '1937',
                    '1936' => '1936',
                    '1935' => '1935',
                    '1934' => '1934',
                    '1933' => '1933',
                    '1932' => '1932',
                    '1931' => '1931'
                );

                $param['country'] = $param['country_study'] = $param['ap_country'] = array(
                    '0'        => '',
                    'USA'      => 'United States',
                    'AF'       => 'Afghanistan',
                    'AX'       => 'Aland Islands',
                    'AL'       => 'Albania',
                    'DZ'       => 'Algeria',
                    'AS'       => 'American Samoa',
                    'AD'       => 'Andorra',
                    'AO'       => 'Angola',
                    'AI'       => 'Anguilla',
                    'ANT'      => 'Antartica',
                    'AG'       => 'Antigua and Barbuda',
                    'AR'       => 'Argentina',
                    'AM'       => 'Armenia',
                    'AW'       => 'Aruba',
                    'AU'       => 'Australia',
                    'AT'       => 'Austria',
                    'AZ'       => 'Azerbaijan',
                    'BS'       => 'Bahamas',
                    'BH'       => 'Bahrain',
                    'BD'       => 'Bangladesh',
                    'BB'       => 'Barbados',
                    'BY'       => 'Belarus',
                    'BE'       => 'Belgium',
                    'BZ'       => 'Belize',
                    'BJ'       => 'Benin',
                    'BM'       => 'Bermuda',
                    'BT'       => 'Bhutan',
                    'BO'       => 'Bolivia',
                    'BQ'       => 'Bonaire',
                    'BA'       => 'Bosnia and Herzegovina',
                    'BW'       => 'Botswana',
                    'BV'       => 'Bouvet Island',
                    'BR'       => 'Brazil',
                    'IO'       => 'British Indian Ocean Territory',
                    'VG'       => 'British Virgin Islands',
                    'BN'       => 'Brunei Darrusalam',
                    'BG'       => 'Bulgaria',
                    'BF'       => 'Burkina Faso',
                    'BI'       => 'Burundi',
                    'KH'       => 'Cambodia',
                    'CM'       => 'Cameroon',
                    'CA'       => 'Canada',
                    'CV'       => 'Cape Verde',
                    'KY'       => 'Cayman Islands',
                    'CF'       => 'Central African Republic',
                    'TD'       => 'Chad',
                    'CL'       => 'Chile',
                    'CN'       => 'China',
                    'CX'       => 'Christmas Island',
                    'CC'       => 'Cocos(Keeling) Islands',
                    'CO'       => 'Colombia',
                    'KM'       => 'Comoros',
                    'CD'       => 'Congo(DR)',
                    'CG'       => 'Congo(R)',
                    'CK'       => 'Cook Islands',
                    'CR'       => 'Costa Rica',
                    'HR'       => 'Croatia',
                    'CU'       => 'Cuba',
                    'CW'       => 'Curaçao',
                    'CY'       => 'Cyprus',
                    'TRNC'     => 'Cyprus(Northern)',
                    'CZ'       => 'Czech Republic',
                    'DK'       => 'Denmark',
                    'DJ'       => 'Djibouti',
                    'DM'       => 'Dominica',
                    'DO'       => 'Dominican Republic',
                    'TL'       => 'East Timor',
                    'EC'       => 'Ecuador',
                    'EG'       => 'Egypt',
                    'SV'       => 'El Salvador',
                    'GB - ENG' => 'England',
                    'GQ'       => 'Equatorial Guinea',
                    'ER'       => 'Eritrea',
                    'EE'       => 'Estonia',
                    'ET'       => 'Ethiopia',
                    'FK'       => 'Falkland Islands',
                    'FO'       => 'Faroe Islands',
                    'FJ'       => 'Fiji',
                    'FI'       => 'Finland',
                    'FR'       => 'France',
                    'GF'       => 'French Guiana',
                    'PF'       => 'French Polynesia',
                    'TF'       => 'French Southern Territories',
                    'GA'       => 'Gabon',
                    'GM'       => 'Gambia',
                    'GE'       => 'Georgia',
                    'DE'       => 'Germany',
                    'GH'       => 'Ghana',
                    'GI'       => 'Gibraltar',
                    'GR'       => 'Greece',
                    'GL'       => 'Greenland',
                    'GD'       => 'Grenada',
                    'GP'       => 'Guadeloupe',
                    'GU'       => 'Guam',
                    'GT'       => 'Guatemala',
                    'GG'       => 'Guernsey',
                    'GN'       => 'Guinea',
                    'GW'       => 'Guinea - Bissau',
                    'GY'       => 'Guyana',
                    'HT'       => 'Haiti',
                    'HM'       => 'Heard Island',
                    'HN'       => 'Honduras',
                    'HK'       => 'Hong Kong',
                    'HU'       => 'Hungary',
                    'IS'       => 'Iceland',
                    'IN'       => 'India',
                    'ID'       => 'Indonesia',
                    'IR'       => 'Iran',
                    'IQ'       => 'Iraq',
                    'IE'       => 'Ireland',
                    'IM'       => 'Isle of Man',
                    'IL'       => 'Israel',
                    'IT'       => 'Italy',
                    'CI'       => 'Ivory Coast',
                    'JM'       => 'Jamaica',
                    'JP'       => 'Japan',
                    'JE'       => 'Jernsey and Guernsey',
                    'JO'       => 'Jordan',
                    'KZ'       => 'Kazakhstan',
                    'KE'       => 'Kenya',
                    'KI'       => 'Kiribati',
                    'KP'       => 'Korea North',
                    'KR'       => 'Korea, South',
                    'KV'       => 'Kosovo',
                    'KW'       => 'Kuwait',
                    'KG'       => 'Kyrgyzstan',
                    'LA'       => 'Laos',
                    'LV'       => 'Latvia',
                    'LB'       => 'Lebanon',
                    'LS'       => 'Lesotho',
                    'LR'       => 'Liberia',
                    'LY'       => 'Libya',
                    'LI'       => 'Liechtenstein',
                    'LT'       => 'Lithuania',
                    'LU'       => 'Luxembourg',
                    'MO'       => 'Macao',
                    'MK'       => 'Macedonia',
                    'MG'       => 'Madagascar',
                    'MW'       => 'Malawi',
                    'MY'       => 'Malaysia',
                    'MV'       => 'Maldives',
                    'ML'       => 'Mali',
                    'MT'       => 'Malta',
                    'MH'       => 'Marshall Islands',
                    'MQ'       => 'Martinique',
                    'MR'       => 'Mauritania',
                    'MU'       => 'Mauritius',
                    'YT'       => 'Mayotte',
                    'MX'       => 'Mexico',
                    'FM'       => 'Micronesia',
                    'MD'       => 'Moldova',
                    'MC'       => 'Monaco',
                    'MN'       => 'Mongolia',
                    'ME'       => 'Montenegro',
                    'MS'       => 'Montserrat',
                    'MA'       => 'Morocco',
                    'MZ'       => 'Mozambique',
                    'MM'       => 'Myanmar',
                    'NA'       => 'Namibia',
                    'NR'       => 'Nauru',
                    'NP'       => 'Nepal',
                    'NL'       => 'Netherlands',
                    'AN'       => 'Netherlands Antilles',
                    'NC'       => 'New Caledonia',
                    'NZ'       => 'New Zealand',
                    'NI'       => 'Nicaragua',
                    'NE'       => 'Niger',
                    'NG'       => 'Nigeria',
                    'NU'       => 'Niue',
                    'NF'       => 'Norfolk Island',
                    'GB - NIR' => 'Northern Ireland',
                    'MP'       => 'Northern Mariana Islands',
                    'NO'       => 'Norway',
                    'OM'       => 'Oman',
                    'PK'       => 'Pakistan',
                    'PW'       => 'Palau',
                    'PS'       => 'Palestinian Territories',
                    'PA'       => 'Panama',
                    'PG'       => 'Papua New Guinea',
                    'PY'       => 'Paraguay',
                    'PE'       => 'Peru',
                    'PH'       => 'Philippines',
                    'PN'       => 'Pitcairn Islands',
                    'PL'       => 'Poland',
                    'PT'       => 'Portugal',
                    'PR'       => 'Puerto Rico',
                    'QA'       => 'Qatar',
                    'RE'       => 'Reunion',
                    'RO'       => 'Romania',
                    'RU'       => 'Russian Federation',
                    'RW'       => 'Rwanda',
                    'BL'       => 'Saint Barthêlemy',
                    'SH'       => 'Saint Helena',
                    'KN'       => 'Saint Kitts and Nevis',
                    'LC'       => 'Saint Lucia',
                    'PM'       => 'Saint Pierre and Miquelon',
                    'VC'       => 'Saint Vincent and the Grenadines',
                    'WS'       => 'Samoa',
                    'SM'       => 'San Marino',
                    'ST'       => 'Sao Tome and Principe',
                    'SA'       => 'Saudi Arabia',
                    'GB - SCT' => 'Scotland',
                    'SN'       => 'Senegal',
                    'RS'       => 'Serbia',
                    'SC'       => 'Seychelles',
                    'SL'       => 'Sierra Leone',
                    'SG'       => 'Singapore',
                    'SX'       => 'Sint Maarten(Dutch)',
                    'SK'       => 'Slovakia',
                    'SI'       => 'Slovenia',
                    'SB'       => 'Solomon Islands',
                    'SO'       => 'Somalia',
                    'ZA'       => 'South Africa',
                    'GS'       => 'South Georgia',
                    'SS'       => 'South Sudan',
                    'ES'       => 'Spain',
                    'LK'       => 'Sri Lanka',
                    'SD'       => 'Sudan',
                    'SR'       => 'Suriname',
                    'SZ'       => 'Swaziland',
                    'SE'       => 'Sweden',
                    'CH'       => 'Switzerland',
                    'SY'       => 'Syria',
                    'TW'       => 'Taiwan',
                    'TJ'       => 'Tajikistan',
                    'TZ'       => 'Tanzania',
                    'TH'       => 'Thailand',
                    'TG'       => 'Togo',
                    'TK'       => 'Tokelau',
                    'TO'       => 'Tonga',
                    'TT'       => 'Trinidad and Tobago',
                    'TN'       => 'Tunisia',
                    'TR'       => 'Turkey',
                    'TM'       => 'Turkmenistan',
                    'TC'       => 'Turks and Caicos Islands',
                    'TV'       => 'Tuvalu',
                    'UG'       => 'Uganda',
                    'UA'       => 'Ukraine',
                    'AE'       => 'United Arab Emirates',
                    'GB'       => 'United Kingdom',
                    'UY'       => 'Uruguay',
                    'UZ'       => 'Uzbekistan',
                    'VU'       => 'Vanuatu',
                    'VA'       => 'Vatican City(Holy See)',
                    'VE'       => 'Venezuela',
                    'VN'       => 'Viet Nam',
                    'VI'       => 'Virgin Islands, US',
                    'GB - WLS' => 'Wales',
                    'WF'       => 'Wallis and Futuna',
                    'EH'       => 'Western Sahara',
                    'YE'       => 'Yemen',
                    'ZM'       => 'Zambia',
                    'ZW'       => 'Zimbabwe',
                    'other'    => 'Other'
                );

                $param['state'] = $param['ap_state'] = array(
                    '0'  => '',
                    'AL' => 'Alabama',
                    'AK' => 'Alaska',
                    'AZ' => 'Arizona',
                    'AR' => 'Arkansas',
                    'CA' => 'California',
                    'CO' => 'Colorado',
                    'CT' => 'Connecticut',
                    'DC' => 'D.C.',
                    'DE' => 'Delaware',
                    'FL' => 'Florida',
                    'GA' => 'Georgia',
                    'HI' => 'Hawaii',
                    'ID' => 'Idaho',
                    'IL' => 'Illinois',
                    'IN' => 'Indiana',
                    'IA' => 'Iowa',
                    'KS' => 'Kansas',
                    'KY' => 'Kentucky',
                    'LA' => 'Louisiana',
                    'ME' => 'Maine',
                    'MP' => 'Mariana Islands',
                    'MD' => 'Maryland',
                    'MA' => 'Massachusetts',
                    'MI' => 'Michigan',
                    'MN' => 'Minnesota',
                    'MS' => 'Mississippi',
                    'MO' => 'Missouri',
                    'MT' => 'Montana',
                    'NE' => 'Nebraska',
                    'NV' => 'Nevada',
                    'NH' => 'New Hampshire',
                    'NJ' => 'New Jersey',
                    'NM' => 'New Mexico',
                    'NY' => 'New York',
                    'NC' => 'North Carolina',
                    'ND' => 'North Dakota',
                    'OH' => 'Ohio',
                    'OK' => 'Oklahoma',
                    'OR' => 'Oregon',
                    'PA' => 'Pennsylvania',
                    'RI' => 'Rhode Island',
                    'SC' => 'South Carolina',
                    'SD' => 'South Dakota',
                    'TN' => 'Tennessee',
                    'TX' => 'Texas',
                    'UT' => 'Utah',
                    'VT' => 'Vermont',
                    'VA' => 'Virginia',
                    'WA' => 'Washington',
                    'WV' => 'West Virginia',
                    'WI' => 'Wisconsin',
                    'WY' => 'Wyoming',
                    'AE' => 'Military Base (AE)'
                );
                break;
        }

        if(count($get) > 0){
            foreach($get as $v){
                if(isset($param[$v])){
                    self::$arParam[$v] = $param[$v];
                }
            }

            return self::$arParam;
        } else {
            unset($param['keyPost']);

            return $param;
        }
    }

    static function createCard(){
        $idCard = q("
            SELECT `AUTO_INCREMENT`
            FROM  INFORMATION_SCHEMA.TABLES
            WHERE TABLE_SCHEMA = '".Core::$DB_NAME."'
            AND   TABLE_NAME   = 'admin_application_info';
        ")->fetch_assoc();

        if(strlen($idCard['AUTO_INCREMENT']) < 5){
            for($i = 5; $i > strlen($idCard['AUTO_INCREMENT']); --$i){
                if(isset($z)){
                    $z .= 0;
                } else {
                    $z = 0;
                }
            }

            $idCard = $z.$idCard['AUTO_INCREMENT'];
        }

        return $idCard;
    }

    static function checkData(){
        if(isset($_COOKIE['idCardHash'])){
            $getInfo = q("
                SELECT *
                FROM `admin_application_info`
                WHERE `idCardHash` = '".mres($_COOKIE['idCardHash'])."'
                AND `agent`   = '".mres($_SERVER['HTTP_USER_AGENT'])."'
                AND `user_ip` = '".mres($_SERVER['REMOTE_ADDR'])."'
                LIMIT 1 
            ");

            if($getInfo->num_rows > 0){
                $option = $getInfo->fetch_assoc();

                if($option['active']){
                    setcookie('idCardHash', '', time() - 3600, '/');

                    // Відправляю у кабінет користувача якщо він проводив вже оплату!
                    sessionInfo('/cab/', '<p>You have completed the application form and successfully submit payment. Information regarding access to your WCES account was sent to your Email.</p>', 1);
                } elseif($option['payment_ok'] && !$option['active']) {
                    setcookie('idCardHash', '', time() - 3600, '/');
                    sessionInfo('/apply/', '<p>Currently, the payment is processed, shortly you will receive the confirmation. Please contact us for additional questions and concerns.</p>', 1);
                }

                $getInfo->data_seek(0);

                return hsc($getInfo->fetch_assoc());
            } else {
                setcookie('idCardHash', '', time() - 3600, '/');

                return false;
            }
        } else {
            return false;
        }
    }

    static function getAllPrice($data){
        if($data['applicant_copy'] == 1){
            $get = 'ap_mailing_us';
        } elseif($data['applicant_copy'] == 2) {
            $get = 'ap_mailing_all';
        }

        $data['report_type'] = (is_array($data['report_type'])? current($data['report_type']) : $data['report_type']);
        $data['ap_mailing'] = (!isset($data['ap_mailing'])? $data[$get] : $data['ap_mailing']);

        $param = self::param(3, array('report_type'));
        $param = self::param(4, array('mailing_copy'));
        $param = self::param(4, array($get));
        $param = self::param(5, array('turnaround_time'));

        $price = 0;
        $price += $param['report_type'][$data['report_type']]['price']; // Report type price;
        $price += $param['turnaround_time'][$data['turnaround_time']]['price']; // Report type price;
        $price += $param[$get][$data['ap_mailing']]['price']; // Applicant copy price

        $arAgencyCopy = q("
            SELECT *
            FROM `admin_official_agency_copy`
            WHERE `idCard` = '".mres($data['idCard'])."'
        ");

        if($arAgencyCopy->num_rows > 0){
            while($copy = hsc($arAgencyCopy->fetch_assoc())){
                $price += (int)$param['mailing_copy'][$copy['mailing_copy']]['price'];
            }
        }

        return $price;
    }

    static function hash($var){
        $salt = 'gy35wsrtytbf';
        $salt2 = 'kh785d323n6f';
        $var = crypt(md5($var.$salt), $salt2);

        return $var;
    }
}