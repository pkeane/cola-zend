{extends file="layout.tpl"}

{block name="content"}
<div id="main-content">
	<form action="{$baseUrl}/list" method="post">
		<p>
		<label for="name">List Name</label>
		<input type="text" name="name">
		<input type="submit" value="create">
		</p>
	</form>
	<ul>
		{foreach item=list from=$lists}
		<li><a href="{$baseUrl}/list/{$list->id}">{$list->name}</a></li>
		{/foreach}
	</ul>
	<div class="clear"></div>
</div>
{/block}
