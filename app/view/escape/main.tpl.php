
<h3> Escaping HTML Attributes</h3>


<h5> Using <code>escapeHtmlAttr </code> to escape a HTML attribute</h5>
<pre><code><?=$e->escapeHTML('<table width="<?php echo $e->escapeHtmlAttr(\'"><h1>Hello</table\'); ?>"><tr><td>Hello</td></tr></table>')?> </code></pre>

<h5> Output</h5>
<xmp>
<table width="<?php echo $e->escapeHtmlAttr('"><h1>Hello</table'); ?>"><tr><td>Hello</td></tr></table>
</xmp>


<h3> Escaping URLs </h3>

<h5>Something something </h5>
<pre><code><?=$e->escapeHTML('<a href="<?php echo $e->escapeUrl(\'"><script>alert(1)</script><a href="#\'); ?>">Some link</a>')?></code></pre>

<h5> Output</h5>
<xmp>
<a href="<?php echo $e->escapeUrl('"><script>alert(1)</script><a href="#'); ?>">Some link</a>
</xmp>
