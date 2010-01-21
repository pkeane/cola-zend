<?php /* Smarty version 2.6.26, created on 2010-01-19 15:14:47
         compiled from list/show.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'extends', 'list/show.tpl', 1, false),array('block', 'block', 'list/show.tpl', 3, false),)), $this); ?>
<?php echo _smarty_swisdk_extends(array('file' => "layout.tpl"), $this);?>


<?php $this->_tag_stack[] = array('block', array('name' => 'content')); $_block_repeat=true;_smarty_swisdk_process_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
<div id="main-content">
	<form action="<?php echo $this->_tpl_vars['baseUrl']; ?>
/list" method="post">
		<p>
		<label for="name">List Name</label>
		<input type="text" name="name">
		<input type="submit" value="create">
		</p>
	</form>
	<ul>
		<?php $_from = $this->_tpl_vars['lists']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['list']):
?>
		<li><?php echo $this->_tpl_vars['list']->name; ?>
</li>
		<?php endforeach; endif; unset($_from); ?>
	</ul>
	<div class="clear"></div>
</div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo _smarty_swisdk_process_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>