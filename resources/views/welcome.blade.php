<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistema FEMEC">
  <meta name="keyword" content="Sistema FEMEC">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>FEMEC</title>
  <link href="css/campus.css" rel="stylesheet">
  <style>
    body:not(.modal-open){
      padding-right: 0px !important;
    }
  </style>
  </head>
<body style="padding: 0px !important;">
	<div id="app">
		<campo></campo>
	</div>
	<script src="js/campus.js"></script>
	<script src="js/app.js"></script>
</body>
</html>
