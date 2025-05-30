var cities = {
  "Rabat-Salé-Kénitra": [
    "Rabat",
    "Salé",
    "Kénitra",
    "Temara",
    "Skhirat",
    "Sidi Kacem",
    "Sidi Slimane",
    "Khémisset",
    "Tanger",
  ],
  "Casablanca-Settat": [
    "Casablanca",
    "Mohammedia",
    "Settat",
    "Benslimane",
    "El Jadida",
    "Azemmour",
    "Marrakech",
    "Moulay Yacoub",
  ],
  "Marrakech-Safi": [
    "Marrakech",
    "Safí",
    "El Kelaa des Sraghna",
    "Chichaoua",
    "Essaouira",
    "Mogador",
  ],
  "Fès-Meknès": [
    "Fès",
    "Meknès",
    "Ifrane",
    "Khénifra",
    "Taza",
    "El Hajeb",
    "Sefrou",
    "Taounate",
    "Boulemane",
    "Missour",
  ],
  "Béni Mellal-Khénifra": [
    "Béni Mellal",
    "Khénifra",
    "Azilal",
    "Fquih Ben Salah",
    "Boudnib",
  ],
  "Drâa-Tafilalet": [
    "Ouarzazate",
    "Errachidia",
    "Midelt",
    "Zagora",
    "Tinerhir",
  ],
  "Souss-Massa": [
    "Agadir",
    "Inezgane",
    "Taroudant",
    "Tiznit",
    "Chtouka Ait Baha",
    "Sidi Ifni",
  ],
  "Guelmim-Oued Noun": ["Guelmim", "Tan-Tan", "Sidi Ifni", "Tata"],
  "Laâyoune-Sakia El Hamra": [
    "Laâyoune",
    "Boujdour",
    "Tarfaya",
    "Smara",
    "Es Smara",
  ],
  "Dakhla-Oued Ed-Dahab": ["Dakhla", "Aousserd", "Oued Ed-Dahab"],
  "Tanger-Tétouan-Al Hoceima": [
    "Tanger",
    "Tétouan",
    "Al Hoceima",
    "M’diq",
    "Chefchaouen",
    "Larache",
    "Ouezzane",
    "Asilah",
    "Martil",
  ],
  Oriental: [
    "Oujda",
    "Nador",
    "Driouch",
    "Jerada",
    "Figuig",
    "Taourirt",
    "Berkane",
  ],
  "Taza-Al Hoceima-Taounate": ["Taza", "Al Hoceima", "Taounate", "Berkane"],
  Meknès: ["Meknès", "Ifrane", "Azrou"],
  Rif: ["Nador", "Driouch", "Al Hoceima", "Taza", "Berkane", "Taourirt"],
  Fès: ["Fès", "Sefrou", "Ifrane", "Moulay Yaacoub", "Bhalil"],
};

var City = function () {
  (this.p = []), (this.c = []), (this.a = []), (this.e = {});
  window.onerror = function () {
    return true;
  };

  this.getProvinces = function () {
    for (let province in cities) {
      this.p.push(province);
    }
    return this.p;
  };
  this.getCities = function (province) {
    if (province.length == 0) {
      console.error("Please input province name");
      return;
    }
    for (let i = 0; i <= cities[province].length - 1; i++) {
      this.c.push(cities[province][i]);
    }
    return this.c;
  };
  this.getAllCities = function () {
    for (let i in cities) {
      for (let j = 0; j <= cities[i].length - 1; j++) {
        this.a.push(cities[i][j]);
      }
    }
    this.a.sort();
    return this.a;
  };
  this.showProvinces = function (element) {
    var str = "<option selected disabled>Select Province</option>";
    for (let i in this.getProvinces()) {
      str += "<option>" + this.p[i] + "</option>";
    }
    this.p = [];
    document.querySelector(element).innerHTML = "";
    document.querySelector(element).innerHTML = str;
    this.e = element;
    return this;
  };
  this.showCities = function (province, element) {
    var str = "<option selected disabled>Select City / Municipality</option>";
    var elem = "";
    if (province.indexOf(".") !== -1 || province.indexOf("#") !== -1) {
      elem = province;
    } else {
      for (let i in this.getCities(province)) {
        str += "<option>" + this.c[i] + "</option>";
      }
      elem = element;
    }
    this.c = [];
    document.querySelector(elem).innerHTML = "";
    document.querySelector(elem).innerHTML = str;
    document.querySelector(this.e).onchange = function () {
      var Obj = new City();
      Obj.showCities(this.value, elem);
    };
    return this;
  };
};
