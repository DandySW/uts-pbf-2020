<!DOCTYPE HTML>
<!--
	Massively by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>

<body class="is-preload">

    <!-- Wrapper -->
    <div id="wrapper" class="fade-in">

        <!-- Intro -->
        @yield('intro')

        <!-- Header -->
        <header id="header">
            <a href="index.html" class="logo">Enjoy the Article</a>
        </header>

        <!-- Nav -->
        <nav id="nav">
            <ul class="links">
                <li class="active"><a href="{{url('/')}}">List Article</a></li>
                <li><a>Content Article</a></li>
                <li><a>Editor</a></li>
            </ul>
            <ul class="icons">
                <li><a href="http://wa.me/6282234795673" class="icon brands fa-whatsapp"><span class="label">Whatspp</span></a></li>
                <li><a href="http://instagram.com/dandysatriow" class="icon brands fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="https://github.com/DandySW" class="icon brands fa-github"><span class="label">GitHub</span></a></li>
            </ul>
        </nav>

        @yield('content')

        <!-- Footer -->
        <footer>
            <div class="pagination">
                <!--<a href="#" class="previous">Prev</a>-->
                <a href="#" class="page active">1</a>
                <a href="#" class="page">2</a>
                <a href="#" class="page">3</a>
                <span class="extra">&hellip;</span>
                <a href="#" class="page">8</a>
                <a href="#" class="page">9</a>
                <a href="#" class="page">10</a>
                <a href="#" class="next">Next</a>
            </div>
        </footer>

    </div>

    <!-- Copyright -->
    <div id="copyright">
        <ul>
            <li>SI C PBF 2020 - <a href="http://sic.pbf.ilkom.unej.ac.id/182410101001/uts/public">182410101001</a></li>
            <li>Template: <a href="https://html5up.net">HTML5 UP</a></li>
        </ul>
    </div>

    </div>

    <!-- Scripts -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrollex.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/browser.min.js"></script>
    <script src="assets/js/breakpoints.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>