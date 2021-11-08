<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

get_header();
?>

	<section id="primary" class="content-area">
		<main id="single" class="site-main">
        <button class="luk">Tilbage</button>
        <section class="indhold">
            <article class="enkeltRet">
                <h2></h2>
                <img id="pic" src="" alt="">
                <p class="text"></p>
            </article>
        </section>
    </main>

    <script>
        //find parametre (variabler) i url'en
       // let urlParams = new URLSearchParams(window.location.search);
        //returner værdien for variablen "id" 
       // let id = urlParams.get("id");
        let ret;
        document.addEventListener("DOMContentLoaded", getJson);

        async function getJson() {
			console.log("id er", <?php echo get_the_ID() ?>);
            //hent en enkelt ret udfra id'et
            let jsonData = await fetch(`http://mabe-kea.dk/E19/babushka/wordpress/wp-json/wp/v2/ret/<?php echo get_the_ID() ?>`);
            ret = await jsonData.json();
            visRet();
        }
        //vis data om retten
        function visRet() {
            document.querySelector("h2").textContent = ret.titel;
            document.querySelector(".text").innerHTML = ret.beskrivelse;
            document.querySelector("#pic").src = ret.billede.guid;
        }

        document.querySelector(".luk").addEventListener("click", () => {
            //link tilbage til den foregående side på "luk" knappen
            history.back();
        })
    </script>

		
	</section><!-- #primary -->

<?php
get_footer();
