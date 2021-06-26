InstapageUtilities = function() {};

InstapageUtilities.prototype.splitForEach = function(iterable, sign, callback) {
  if (iterable) {
    iterable
      .split(sign)
      .forEach(callback);
  }
};

InstapageUtilities.prototype.csvToMap = function(csv) {
  var map = {};
  this.splitForEach(csv, ',', function addToMap(element){
    map[element.trim()] = true;
  });
  return map;
};

InstapageUtilities.prototype.mapToCsv = function(map) {
  return Object.keys(map).join(',');
}

InstapageUtilities.prototype.getMetatagContent = function(metaName) {
  return jQuery('meta[name="' + metaName + '"]').attr('content');
}
