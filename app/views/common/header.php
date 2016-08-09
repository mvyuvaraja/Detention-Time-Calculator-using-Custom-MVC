</head>
<body>
	<div class="easyui-layout" style="width:100%;height:630px;">
		<div data-options="region:'north'" style="height:50px">
            <h3 class="phead">Detention Time Calculator using Custom MVC</h3>
        </div>
		<div data-options="region:'south',split:true" style="height:50px;text-align:center;">All rights reserved</div>
		<div data-options="region:'west',split:true" title="ADMIN" style="width:200px;">
            <ul class="cl-menu">
                <li <?php echo $GLOBALS['req_action'] == 'offense@index' ? 'class="active"': "" ?> ><a href="/offense">Offense Types</a></li>
                <li <?php echo $GLOBALS['req_action'] == 'detention@index' ? 'class="active"': "" ?> ><a href="/detention">Detention Management</a></li>
                <li <?php echo $GLOBALS['req_action'] == 'calculator@index' ? 'class="active"': "" ?> ><a href="/calculator">Detention Calculator</a></li>
            </ul>
        </div>
