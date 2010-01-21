<?php /* Smarty version 2.6.26, created on 2010-01-19 15:53:10
         compiled from error/index.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'extends', 'error/index.tpl', 1, false),array('block', 'block', 'error/index.tpl', 4, false),array('modifier', 'print_r', 'error/index.tpl', 20, false),)), $this); ?>
<?php echo _smarty_swisdk_extends(array('file' => "layout.tpl"), $this);?>



<?php $this->_tag_stack[] = array('block', array('name' => 'content')); $_block_repeat=true;_smarty_swisdk_process_block($this->_tag_stack[count($this->_tag_stack)-1][1], null, $this, $_block_repeat);while ($_block_repeat) { ob_start(); ?>
<div id="main-content">
  <h1>An error occurred</h1>
  <h2><?php echo $this->_tpl_vars['msg']; ?>
</h2>

  <?php if ($this->_tpl_vars['isdev']): ?>
  <h3>Exception information:</h3>
  <p>
  <b>Message:</b> <?php echo $this->_tpl_vars['exception']->getMessage(); ?>

  </p>

  <h3>Stack trace:</h3>
  <pre><?php echo $this->_tpl_vars['exception']->getTraceAsString(); ?>
}
  </pre>

  <h3>Request Parameters:</h3>
  <pre> <?php echo print_r($this->_tpl_vars['request']->getParams()); ?>

  </pre>
  <?php endif; ?>
</div>
<?php $_block_content = ob_get_contents(); ob_end_clean(); $_block_repeat=false;echo _smarty_swisdk_process_block($this->_tag_stack[count($this->_tag_stack)-1][1], $_block_content, $this, $_block_repeat); }  array_pop($this->_tag_stack); ?>