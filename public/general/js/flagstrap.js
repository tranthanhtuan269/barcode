/*
 *  FlagStrap - v1.0
 *  A lightwieght jQuery plugin for creating Bootstrap 3 compatible country select boxes with flags.
 *  http://www.blazeworx.com/flagstrap
 *
 *  Made by Alex Carter
 *  Under MIT License
 */
! function(a) {
    var b = {
            buttonSize: "btn-md",
            buttonType: "btn-default",
            labelMargin: "10px",
            scrollable: !0,
            scrollableHeight: "250px",
            placeholder: {
                value: "",
                // text: "Please select country"
            }
        },
        c = {
            GB: "United Kingdom",
            VN: "Viet Nam",
            // AF: "Afghanistan",
            // AL: "Albania",
            // DZ: "Algeria",
            // AS: "American Samoa",
            // AD: "Andorra",
            // AO: "Angola",
            // AI: "Anguilla",
            // AG: "Antigua and Barbuda",
            // AR: "Argentina",
            // AM: "Armenia",
            // AW: "Aruba",
            // AU: "Australia",
            // AT: "Austria",
            // AZ: "Azerbaijan",
            // BS: "Bahamas",
            // BH: "Bahrain",
            // BD: "Bangladesh",
            // BB: "Barbados",
            // BY: "Belarus",
            // BE: "Belgium",
            // BZ: "Belize",
            // BJ: "Benin",
            // BM: "Bermuda",
            // BT: "Bhutan",
            // BO: "Bolivia, Plurinational State of",
            // BA: "Bosnia and Herzegovina",
            // BW: "Botswana",
            // BV: "Bouvet Island",
            // BR: "Brazil",
            // IO: "British Indian Ocean Territory",
            // BN: "Brunei Darussalam",
            // BG: "Bulgaria",
            // BF: "Burkina Faso",
            // BI: "Burundi",
            // KH: "Cambodia",
            // CM: "Cameroon",
            // CA: "Canada",
            // CV: "Cape Verde",
            // KY: "Cayman Islands",
            // CF: "Central African Republic",
            // TD: "Chad",
            // CL: "Chile",
            // CN: "China",
            // CO: "Colombia",
            // KM: "Comoros",
            // CG: "Congo",
            // CD: "Congo, the Democratic Republic of the",
            // CK: "Cook Islands",
            // CR: "Costa Rica",
            // CI: "C&ocirc;te d'Ivoire",
            // HR: "Croatia",
            // CU: "Cuba",
            // CW: "Cura&ccedil;ao",
            // CY: "Cyprus",
            // CZ: "Czech Republic",
            // DK: "Denmark",
            // DJ: "Djibouti",
            // DM: "Dominica",
            // DO: "Dominican Republic",
            // EC: "Ecuador",
            // EG: "Egypt",
            // SV: "El Salvador",
            // GQ: "Equatorial Guinea",
            // ER: "Eritrea",
            // EE: "Estonia",
            // ET: "Ethiopia",
            // FK: "Falkland Islands (Malvinas)",
            // FO: "Faroe Islands",
            // FJ: "Fiji",
            // FI: "Finland",
            // FR: "France",
            // GF: "French Guiana",
            // PF: "French Polynesia",
            // TF: "French Southern Territories",
            // GA: "Gabon",
            // GM: "Gambia",
            // GE: "Georgia",
            // DE: "Germany",
            // GH: "Ghana",
            // GI: "Gibraltar",
            // GR: "Greece",
            // GL: "Greenland",
            // GD: "Grenada",
            // GP: "Guadeloupe",
            // GU: "Guam",
            // GT: "Guatemala",
            // GG: "Guernsey",
            // GN: "Guinea",
            // GW: "Guinea-Bissau",
            // GY: "Guyana",
            // HT: "Haiti",
            // HM: "Heard Island and McDonald Islands",
            // VA: "Holy See (Vatican City State)",
            // HN: "Honduras",
            // HK: "Hong Kong",
            // HU: "Hungary",
            // IS: "Iceland",
            // IN: "India",
            // ID: "Indonesia",
            // IR: "Iran, Islamic Republic of",
            // IQ: "Iraq",
            // IE: "Ireland",
            // IM: "Isle of Man",
            // IL: "Israel",
            // IT: "Italy",
            // JM: "Jamaica",
            // JP: "Japan",
            // JE: "Jersey",
            // JO: "Jordan",
            // KZ: "Kazakhstan",
            // KE: "Kenya",
            // KI: "Kiribati",
            // KP: "Korea, Democratic People's Republic of",
            // KR: "Korea, Republic of",
            // KW: "Kuwait",
            // KG: "Kyrgyzstan",
            // LA: "Lao People's Democratic Republic",
            // LV: "Latvia",
            // LB: "Lebanon",
            // LS: "Lesotho",
            // LR: "Liberia",
            // LY: "Libya",
            // LI: "Liechtenstein",
            // LT: "Lithuania",
            // LU: "Luxembourg",
            // MO: "Macao",
            // MK: "Macedonia, the former Yugoslav Republic of",
            // MG: "Madagascar",
            // MW: "Malawi",
            // MY: "Malaysia",
            // MV: "Maldives",
            // ML: "Mali",
            // MT: "Malta",
            // MH: "Marshall Islands",
            // MQ: "Martinique",
            // MR: "Mauritania",
            // MU: "Mauritius",
            // YT: "Mayotte",
            // MX: "Mexico",
            // FM: "Micronesia, Federated States of",
            // MD: "Moldova, Republic of",
            // MC: "Monaco",
            // MN: "Mongolia",
            // ME: "Montenegro",
            // MS: "Montserrat",
            // MA: "Morocco",
            // MZ: "Mozambique",
            // MM: "Myanmar",
            // NA: "Namibia",
            // NR: "Nauru",
            // NP: "Nepal",
            // NL: "Netherlands",
            // NC: "New Caledonia",
            // NZ: "New Zealand",
            // NI: "Nicaragua",
            // NE: "Niger",
            // NG: "Nigeria",
            // NU: "Niue",
            // NF: "Norfolk Island",
            // MP: "Northern Mariana Islands",
            // NO: "Norway",
            // OM: "Oman",
            // PK: "Pakistan",
            // PW: "Palau",
            // PS: "Palestinian Territory, Occupied",
            // PA: "Panama",
            // PG: "Papua New Guinea",
            // PY: "Paraguay",
            // PE: "Peru",
            // PH: "Philippines",
            // PN: "Pitcairn",
            // PL: "Poland",
            // PT: "Portugal",
            // PR: "Puerto Rico",
            // QA: "Qatar",
            // RE: "R&eacute;union",
            // RO: "Romania",
            // RU: "Russian Federation",
            // RW: "Rwanda",
            // SH: "Saint Helena, Ascension and Tristan da Cunha",
            // KN: "Saint Kitts and Nevis",
            // LC: "Saint Lucia",
            // MF: "Saint Martin (French part)",
            // PM: "Saint Pierre and Miquelon",
            // VC: "Saint Vincent and the Grenadines",
            // WS: "Samoa",
            // SM: "San Marino",
            // ST: "Sao Tome and Principe",
            // SA: "Saudi Arabia",
            // SN: "Senegal",
            // RS: "Serbia",
            // SC: "Seychelles",
            // SL: "Sierra Leone",
            // SG: "Singapore",
            // SX: "Sint Maarten (Dutch part)",
            // SK: "Slovakia",
            // SI: "Slovenia",
            // SB: "Solomon Islands",
            // SO: "Somalia",
            // ZA: "South Africa",
            // GS: "South Georgia and the South Sandwich Islands",
            // SS: "South Sudan",
            // ES: "Spain",
            // LK: "Sri Lanka",
            // SD: "Sudan",
            // SR: "Suriname",
            // SZ: "Swaziland",
            // SE: "Sweden",
            // CH: "Switzerland",
            // SY: "Syrian Arab Republic",
            // TW: "Taiwan, Province of China",
            // TJ: "Tajikistan",
            // TZ: "Tanzania, United Republic of",
            // TH: "Thailand",
            // TL: "Timor-Leste",
            // TG: "Togo",
            // TK: "Tokelau",
            // TO: "Tonga",
            // TT: "Trinidad and Tobago",
            // TN: "Tunisia",
            // TR: "Turkey",
            // TM: "Turkmenistan",
            // TC: "Turks and Caicos Islands",
            // TV: "Tuvalu",
            // UG: "Uganda",
            // UA: "Ukraine",
            // AE: "United Arab Emirates",
            // US: "United States",
            // UM: "United States Minor Outlying Islands",
            // UY: "Uruguay",
            // UZ: "Uzbekistan",
            // VU: "Vanuatu",
            // VE: "Venezuela, Bolivarian Republic of",
            // VG: "Virgin Islands, British",
            // VI: "Virgin Islands, U.S.",
            // WF: "Wallis and Futuna",
            // EH: "Western Sahara",
            // YE: "Yemen",
            // ZM: "Zambia",
            // ZW: "Zimbabwe"
        };
    a.flagStrap = function(d, e) {
        function f(a) {
            var b = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz".split("");
            a || (a = Math.floor(Math.random() * b.length));
            for (var c = "", d = 0; a > d; d++) c += b[Math.floor(Math.random() * b.length)];
            return c
        }
        var g = this,
            h = f(8);
        g.countries = {}, g.selected = {
            value: null,
            text: null
        }, g.settings = {
            inputName: "country-" + h
        };
        var i = a(d),
            j = "flagstrap-" + h,
            k = "#" + j;
        g.init = function() {
            g.countries = c, g.countries = c, g.settings = a.extend({}, b, e, i.data()), void 0 !== g.settings.countries && (g.countries = g.settings.countries), void 0 !== g.settings.inputId && (j = g.settings.inputId, k = "#" + j), i.addClass("flagstrap").append(l).append(m).append(n), void 0 !== g.settings.onSelect && g.settings.onSelect instanceof Function && a(k).change(function() {
                var b = this;
                e.onSelect(a(b).val(), b)
            }), a(k).hide()
        };
        var l = function() {
                var b = a("<select/>").attr("id", j).attr("name", g.settings.inputName);
                return a.each(g.countries, function(c, d) {
                    var e = {
                        value: c
                    };
                    void 0 !== g.settings.selectedCountry && g.settings.selectedCountry === c && (e = {
                        value: c,
                        selected: "selected"
                    }, g.selected = {
                        value: c,
                        text: d
                    }), b.append(a("<option>", e).text(d))
                }), g.settings.placeholder !== !1 && b.prepend(a("<option>", {
                    value: g.settings.placeholder.value,
                    text: g.settings.placeholder.text
                })), b
            },
            m = function() {
                var b = a(k).find("option").first().text(),
                    c = a(k).find("option").first().val();
                if (b = g.selected.text || b, c = g.selected.value || c, c !== g.settings.placeholder.value) var d = a("<i/>").addClass("flagstrap-icon flagstrap-" + c.toLowerCase()).css("margin-right", g.settings.labelMargin);
                else var d = a("<i/>").addClass("flagstrap-icon flagstrap-placeholder");
                var e = a("<span/>").addClass("flagstrap-selected-" + h).html(d).append(b),
                    f = a("<button/>").attr("type", "button").attr("data-toggle", "dropdown").attr("id", "flagstrap-drop-down-" + h).addClass("btn " + g.settings.buttonType + " " + g.settings.buttonSize + " dropdown-toggle").html(e);
                return a("<span/>").addClass("caret").css("margin-left", g.settings.labelMargin).insertAfter(e), f
            },
            n = function() {
                var b = a("<ul/>").attr("id", "flagstrap-drop-down-" + h + "-list").attr("aria-labelled-by", "flagstrap-drop-down-" + h).addClass("dropdown-menu pointer");
                return g.settings.scrollable && b.css("height", "auto").css("max-height", g.settings.scrollableHeight).css("overflow-x", "hidden"), a(k).find("option").each(function() {
                    var c = a(this).text(),
                        d = a(this).val();
                    if (d !== g.settings.placeholder.value) var e = a("<i/>").addClass("flagstrap-icon flagstrap-" + d.toLowerCase()).css("margin-right", g.settings.labelMargin);
                    else var e = null;
                    var f = a("<a/>").attr("data-val", a(this).val()).html(e).append(c).on("click", function(b) {
                            a(k).find("option").removeAttr("selected"), a(k).find('option[value="' + a(this).data("val") + '"]').attr("selected", "selected"), a(k).trigger("change"), a(".flagstrap-selected-" + h).html(a(this).html()), b.preventDefault()
                        }),
                        i = a("<li/>").prepend(f);
                    b.append(i)
                }), b
            };
        g.init()
    }, a.fn.flagStrap = function(b) {
        return this.each(function(c) {
            void 0 === a(this).data("flagStrap") && a(this).data("flagStrap", new a.flagStrap(this, b, c))
        })
    }
}(jQuery);