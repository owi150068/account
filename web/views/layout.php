<!DOCTYPE html>
<html>
    <head>
        <title>Account</title>
        <link rel="stylesheet" href="{{ webroot }}style/global.css">
       <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    </head>
    <body>
        <div id="banner">
            ACCOUNT
        </div>
        <header class="well">
            <div class="loggedin">
                <p>You are logged in as {{ app.session.get('name') }}</p>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ webroot }}settings">SETTINGS</a></li>
                    <li><a href="{{ webroot }}friends">FRIENDS</a></li>
                </ul>
            </nav>
        </header>
        <main class="well">
            {% block content %}
            {% endblock %}
        </main>
    </body>
</html>