// ** I18N
Calendar._DN = new Array
("Duminica",
 "Luni",
 "Marti",
 "Miercuri",
 "Joi",
 "Vineri",
 "Sambata",
 "Duminica");
Calendar._SDN_len = 2;
Calendar._MN = new Array
("Ianuarie",
 "Februarie",
 "Martie",
 "Aprilie",
 "Mai",
 "Iunie",
 "Iulie",
 "August",
 "Septembrie",
 "Octombrie",
 "Noiembrie",
 "Decembrie");

// tooltips
Calendar._TT = {};

Calendar._TT["INFO"] = "Despre calendar";

Calendar._TT["ABOUT"] =
"Selectia datei:\n" +
"- Folositi butoanele \xab, \xbb pentru a selecta anul\n" +
"- Folositi butoanele " + String.fromCharCode(0x2039) + ", " + String.fromCharCode(0x203a) + " pentru a selecta luna\n" +
"- Tineti butonul mouse-ului apasat pentru selectie mai rapida.";
Calendar._TT["ABOUT_TIME"] = "\n\n" +
"Selectia orei:\n" +
"- Click pe ora sau minut pentru a mari valoarea cu 1\n" +
"- Sau Shift-Click pentru a micsora valoarea cu 1\n" +
"- Sau Click si drag pentru a selecta mai repede.";

Calendar._TT["PREV_YEAR"] = "Anul precedent (lung pt menu)";
Calendar._TT["PREV_MONTH"] = "Luna precedenta (lung pt menu)";
Calendar._TT["GO_TODAY"] = "Data de azi";
Calendar._TT["NEXT_MONTH"] = "Luna urmatoare (lung pt menu)";
Calendar._TT["NEXT_YEAR"] = "Anul urmator (lung pt menu)";
Calendar._TT["SEL_DATE"] = "Selecteaza data";
Calendar._TT["DRAG_TO_MOVE"] = "Trage pentru a misca";
Calendar._TT["PART_TODAY"] = " (astazi)";
Calendar._TT["DAY_FIRST"] = "Afiseaza %s prima zi";
Calendar._TT["WEEKEND"] = "0,6";
Calendar._TT["CLOSE"] = "Închide";
Calendar._TT["TODAY"] = "Astazi";
Calendar._TT["TIME_PART"] = "(Shift-)Click sau drag pentru a selecta";

// date formats
Calendar._TT["DEF_DATE_FORMAT"] = "%d-%m-%Y";
Calendar._TT["TT_DATE_FORMAT"] = "%A, %d %B";

Calendar._TT["WK"] = "spt";
Calendar._TT["TIME"] = "Ora:";
