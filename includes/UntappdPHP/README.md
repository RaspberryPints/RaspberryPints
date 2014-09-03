UntappdPHP
==========

A simple way to connect to the Untappd API to make calls in PHP

This a library written to interact with the Untappd API (https://untappd.com/api) using both oAuth Authenticated Calls and Non-Authenticated calls. I am one of co-founder of Untappd, and we use a similar piece of code on untappd.com.<br />

# Requirements
PHP 5+<br />
CURL<br />

# Getting Started
In order to get access the API - go https://untappd.com/api and request an API token. Please note it may take up to 2 weeks to a API keys. Only application ideas are accepeted at this time to perserve infrastruture and bandwidth.

Follow the instructions in <code>oauth_examples/..</code> for a detailed example of the OAuth authentication. If you want basic authentication examples, please see the <code>basic_examples/..</code> folder.

<br />After obtaining the Authentication tokens, if you want to make authenticated calls you just need to use the following method:

<pre>
$ut = new UntappdPHP(client_id, client_secret, redirect_uri, acesss_token);
$res = $ut->get(METHOD_HERE, PARAMS_HERE);
</pre>

If you are using non-authenticated calls - all you need to do is use the <code>get</code> method:

<pre>
$ut = new UntappdPHP(client_id, client_secret);
$res = $ut->get(METHOD_HERE, PARAMS_HERE);
</pre>

For full details on the documentations of the API visit https://untappd.com/api/docs

# To Do
Error Handling

# Getting Help
If you need help or have questions, please contact Greg Avola on Twitter at http://twitter.com/gregavola

# About
This library was inspired by Abraham's version of Twitter OAuth - https://github.com/abraham/twitteroauth
