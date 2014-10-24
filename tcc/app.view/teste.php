<!doctype html>
<html lang="en">
<head>
	<title>jQuery UI Accordion - Customize icons</title>
        <link type="text/css" href="../css/jquery/ui.all.css" rel="stylesheet" />
        <script type="text/javascript" src="../jscripts/jquery/jquery-1.3.2.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.core.js"></script>
        <script type="text/javascript" src="../jscripts/jquery/ui.accordion.js"></script>
        <link type="text/css" href="../css/jquery/demos.css" rel="stylesheet" />
	<script type="text/javascript">
	$(function() {
		$("#area_medica").accordion({
                        autoHeight: true,
			icons: {
    			header: "ui-icon-circle-arrow-e",
   				headerSelected: "ui-icon-circle-arrow-s"

			}
                      
		});

                $("#sub_area").accordion({
                          autoHeight: true,
			icons: {
    			header: "ui-icon-circle-arrow-e",
   				headerSelected: "ui-icon-circle-arrow-s"

			}
		});
	});
	</script>
</head>
<body>
<div id="area_medica">
	<h3><a href="#">Ginecologia</a></h3>
	<div>
            <div id="sub_area">
                <h3><a href="#">Mamografia</a> </h3>
                <div>
                     <p> tabela de patologias </p>
                </div>
                <h3><a href="#">Colposcopia</a></h3>
                <div>

                </div>
                <h3><a href="#">Section 1c</a></h3>
                <div>

                </div>
             </div>
	</div>
	<h3><a href="#">Section</a></h3>
        <div>
	</div>
</div>

</body>
</html>
