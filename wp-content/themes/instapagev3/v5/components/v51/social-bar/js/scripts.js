var getPostID = function() {
  var bodyClass = jQuery('body').attr('class');
  var pattern = /postid-(\d*)/;

  if (typeof bodyClass !== 'undefined') {
    bodyClass = bodyClass.toString();
  } else {
    return 0;
  }

  var result = pattern.exec(bodyClass);

  return (result !== null) ? result[1] : 0;
};