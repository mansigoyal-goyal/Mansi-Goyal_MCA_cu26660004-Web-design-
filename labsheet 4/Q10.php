<?php
$pageTitle = 'Q10 - Apache Virtual Host';
require 'includes/header.php';
?>
<section class="card"><h1>Question 10: Configure an Apache virtual host</h1>
<p>Example configuration is saved in <code>apache/httpd-vhosts.conf.example</code>. Update the paths to match your Apache installation.</p>
<pre>&lt;VirtualHost *:80&gt;
    ServerName collegeweb.local
    DocumentRoot "C:/xampp/htdocs/collegeweb"
    &lt;Directory "C:/xampp/htdocs/collegeweb"&gt;
        AllowOverride All
        Require all granted
    &lt;/Directory&gt;
&lt;/VirtualHost&gt;</pre>
<p>Add this line to the Windows hosts file as Administrator:</p><pre>127.0.0.1 collegeweb.local</pre>
<p>Enable <code>mod_vhost_alias</code> only if needed, ensure the vhosts include directive is active, restart Apache, then open <code>http://collegeweb.local</code>.</p>
</section><?php require 'includes/footer.php'; ?>