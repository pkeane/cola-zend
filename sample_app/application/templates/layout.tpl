<html>
	<head>
		<base href="/listmaker/public/"/>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		{block name="head-meta"}{/block}
		<title>{block name="title"}VRC Slides{/block}</title>
		<style type="text/css">
			{block name="style"}{/block}
		</style>

		<link rel="stylesheet" href="{$baseUrl}/css/960/reset.css" />
		<link rel="stylesheet" href="{$baseUrl}/css/960/text.css" />

		<link rel="stylesheet" type="text/css" href="{$baseUrl}/css/style.css">
		{block name="head-links"}{/block}

		<script type="text/javascript" src="{$baseUrl}/js/jquery.js"></script>
		{block name="head"}{/block}

	</head>
	<body>
		<div class="topper">
			<h1>Listmaker</h1>
		</div>
		{block name="content"}default content{/block}
	</body>
</html>

