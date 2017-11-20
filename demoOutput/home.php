<!DOCTYPE html> <html> <head> <title>API Docu</title> <style>html,body{margin:0;padding:0;height:100%;width:100%;font-size:12px}h1,h2,h3,h4,h5,h6{margin:0 0 1em 0;font-weight:600}p{margin:0 0 1em 0}h1{font-size:2.2em}h2{font-size:1.7em}h3{font-size:1.37em}h4{font-size:1em}h5{font-size:1.03em}h6{font-size:.87em}ul{margin:1em 0 1.5em}h2:first-of-type::before{content:"Section: ";font-weight:400;color:#949aa0}a{color:#3498db;text-decoration:none}a:visited{color:#3498db}a:hover{text-decoration:underline}body{background-color:transparent;font-size:14px;font-family:Arial,Helvetica,sans-serif;color:#2c3e50;height:auto}main{background-color:#fff;padding:1em;border-radius:2px;box-sizing:border-box}pre{background-color:#ecf0f1;padding:.5em;font-size:12px;font-family:"Lucida Console",Monaco,monospace}code{background-color:#ecf0f1;color:#8e44ad;padding:2px 4px;font-size:12px;font-family:"Lucida Console",Monaco,monospace}pre code{background-color:#ecf0f1;color:#2c3e50;padding:none}pre:last-child{margin-bottom:0}.language-json-string{color:#e67e22}.language-json-number{color:#138C58}</style> </head> <body> <main> <h2>Home</h2> <p>This is a documentation of our cookbook JSON-RPC API. If you are having any troubles baking your own API client, please contact our chef Pavel Janda.</p> <h3>Specification</h3> <h4>Endpoint</h4> <p>All api calls should be targeting uri <code>api.example.io</code>. According to <a href="http://www.jsonrpc.org/specification">JSON-RPC specification</a>, each and every request object has to contain following properties:</p> <ul> <li><code>jsonrpc</code>: JSON-RPC version (<code>"2.0"</code>)</li> <li><code>method</code>: Name of the method to be invoked</li> <li>`params: Parameters of particular call (optional)</li> <li><code>id</code>: An string identifying this call (may be <code>null</code>)</li> </ul> <h4>Example request payload:</h4> <pre><code class="language-json">{
    "jsonrpc": "2.0",
    "method": "Receipe.store",
    "params": {
        "name": "Bread with butter",
        "ingredients": [
            "bread",
            "butter"
        ],
        "timeNeeded": 2
    },
    "id": null
}</code></pre> </main> </body> </html> 