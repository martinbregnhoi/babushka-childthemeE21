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

	<section id="primary" class="content-area retter entry">
		<main id="main" class="site-main entry-content">
      <!--        <nav>
            <button class="filter" data-ret="alle">Alle</button>
            <button class="filter" data-ret="forretter">Forretter</button>
            <button class="filter" data-ret="hovedretter">Hovedretter</button>
            <button class="filter" data-ret="desserter">Desserter</button>
            <button class="filter" data-ret="drikkevarer">Drikkevarer</button>
        </nav>-->
            <nav id="filtrering"><button class="filter" data-ret="alle">Alle</button></nav>
        <h1 id="overskrift">Retter</h1>
        <section id="ret-oversigt"></section>
    </main>
    <template>
        <article>
            <h2></h2>
            <img src="" alt="">
            <p></p>
        </article>
    </template>
    <script>
		const siteUrl = "<?php echo esc_url( home_url( '/' ) ); ?>";
        let retter = [];
        let categories = [];
        const liste = document.querySelector("#ret-oversigt");
        const skabelon = document.querySelector("template");
        let filterRet = "alle";
        document.addEventListener("DOMContentLoaded", start);
        
        function start() {
            
            console.log("id er", <?php echo get_the_ID() ?>);
            console.log(siteUrl);
            
            getJson();
            //addEventListenersToButtons();
        }

        async function getJson() {
            const url = siteUrl +"wp-json/wp/v2/ret?per_page=100";
            const catUrl = "http://mabe-kea.dk/E19/babushka/wordpress/wp-json/wp/v2/categories";
            let response = await fetch(url);
            let catResponse = await fetch(catUrl);
            retter = await response.json();
            categories = await catResponse.json();
            visRetter();
            opretKnapper();
        }
            function opretKnapper(){
            
            categories.forEach(cat=>{
               console.log(cat.name);
                if(cat.name != "Uncategorized"){
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-ret="${cat.name}">${cat.name}</button>`
                }
            })
            
            addEventListenersToButtons2();
        }

        function visRetter() {
            console.log(retter);
            liste.innerHTML = "";
            retter.forEach(ret => {
				
                if (filterRet == "alle" || ret.categories.includes(filterRet)) {
                    const klon = skabelon.cloneNode(true).content;
                    klon.querySelector("h2").textContent = ret.titel;
                    klon.querySelector("img").src = ret.billede.guid;
                    klon.querySelector("p").innerHTML = ret.pris + " kr";
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = ret.link;
                    })
                    liste.appendChild(klon);
                }
            })

        }
         function addEventListenersToButtons2() {
            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.addEventListener("click", filtrering);
            })
        }
        
     /*   function addEventListenersToButtons() {
            document.querySelectorAll("nav button").forEach(elm => {
                elm.addEventListener("click", filtrering);
            })
        }*/

        function filtrering() {
            filterRet = this.dataset.ret;
            console.log(filterRet);
            document.querySelector("h1").textContent = this.textContent;
            document.querySelectorAll(".filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
            //console.log(this);
            this.classList.add("valgt");
            visRetter();
        }
    </script>

	</section><!-- #primary -->

<?php
get_footer();
