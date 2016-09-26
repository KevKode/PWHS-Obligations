<?php session_start(); ?>
<?php include "settingsPHP/header.php"; ?>
<head>
<link rel="stylesheet" type="text/css" href="typeahead/typeaheadjs.css">
</head>
<script src="typeahead/typeaheadfile.js"></script>
<div id="the-basics" class="col-lg-4 control-label">
  <input class="typeahead" type="text" placeholder="Enter a teacher">
</div>
<script>
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substrRegex;
 
    // an array that will be populated with substring matches
    matches = [];
 
    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');
 
    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        // the typeahead jQuery plugin expects suggestions to a
        // JavaScript object, refer to typeahead docs for more info
        matches.push({ value: str });
      }
    });
 
    cb(matches);
  };
};
 
var teachers = ['Mickey Engel', 'Nicole Butler', 'Ryan Zheren', 'Eric Scheidly', 'Jean Casey'];
 
$('#the-basics .typeahead').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'teachers',
  displayKey: 'value',
  source: substringMatcher(teachers)
});
</script>

<?php require "settingsPHP/footer.php"?>
