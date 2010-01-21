{extends file="layout.tpl"}


{block name="content"}
<div id="main-content">
  <h1>An error occurred</h1>
  <h2>{$msg}</h2>

  {if  $isdev }
  <h3>Exception information:</h3>
  <p>
  <b>Message:</b> {$exception->getMessage()}
  </p>

  <h3>Stack trace:</h3>
  <pre>{$exception->getTraceAsString()}}
  </pre>

  <h3>Request Parameters:</h3>
  <pre> {$request->getParams()|@print_r}
  </pre>
  {/if}
</div>
{/block}
