{include file="header.tpl"}

<div><b>This is the result of IndexController::indexAction()</b></div>

<br/>

<div>Hello {$name}!</div>

<br/>

<div>Here is {$name}'s favorite fruits:
<ul>
  {section name="favFruits" loop="$fruits"}
    <li>{$fruits[favFruits]}</li>
  {/section}
</ul>
</div>

{include file="footer.tpl"}