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
  
            <nav id="indhold-filtrering"><button class="filter valgt" data-cont="alle">Alle</button></nav>
            <nav id="filtrering"><button class="filter valgt" data-ret="alle">Alle</button></nav>
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
        let indhold = [];
        const liste = document.querySelector("#ret-oversigt");
        const skabelon = document.querySelector("template");
        let filterRet = "alle";
        let filterIndhold = "alle";
        document.addEventListener("DOMContentLoaded", start);
        
        function start() {
            
            console.log("id er", <?php echo get_the_ID() ?>);
            console.log(siteUrl);
            
            getJson();
    
        }

        async function getJson() {
            //hent alle custom posttypes retter
            const url = siteUrl +"wp-json/wp/v2/ret?per_page=100";
            //hent basis categories
            const catUrl = "http://mabe-kea.dk/E19/babushka/wordpress/wp-json/wp/v2/categories";
             //hent custom category: indhold
            const contUrl = "http://mabe-kea.dk/E19/babushka/wordpress/wp-json/wp/v2/indhold";
            let response = await fetch(url);
            let catResponse = await fetch(catUrl);
            let contResponse = await fetch(contUrl);
            retter = await response.json();
            categories = await catResponse.json();
            indhold = await contResponse.json();
            visRetter();
            opretKnapper();
        }
            function opretKnapper(){
            
            categories.forEach(cat=>{
               //console.log(cat.id);
                if(cat.name != "Uncategorized"){
                document.querySelector("#filtrering").innerHTML += `<button class="filter" data-ret="${cat.id}">${cat.name}</button>`
                }
            })
              indhold.forEach(cont=>{
               //console.log(cont.id);
                document.querySelector("#indhold-filtrering").innerHTML += `<button class="filter" data-cont="${cont.id}">${cont.name}</button>`
             
            })
            addEventListenersToButtons();
        }

        function visRetter() {
            console.log(retter);
            liste.innerHTML = "";
            console.log({filterRet});
            console.log({filterIndhold});
            retter.forEach(ret => {
                //tjek filterRet og filterIndhold til filtrering
                if ((filterRet == "alle"  || ret.categories.includes(parseInt(filterRet))) && (filterIndhold == "alle"  || ret.indhold.includes(parseInt(filterIndhold)))) {
                    const klon = skabelon.cloneNode(true).content;
                    klon.querySelector("h2").textContent = ret.title.rendered;
                    klon.querySelector("img").src = ret.billede.guid;
                    klon.querySelector("p").innerHTML = ret.pris + " kr";
                    klon.querySelector("article").addEventListener("click", () => {
                        location.href = ret.link;
                    })
                    liste.appendChild(klon);
                }
            })

        }
         function addEventListenersToButtons() {
            document.querySelectorAll("#filtrering button").forEach(elm => {
                elm.addEventListener("click", filtrering);
            })
             document.querySelectorAll("#indhold-filtrering button").forEach(elm => {
                elm.addEventListener("click", filtreringIndhold);
            })
        }
        
        function filtrering() {
            filterRet = this.dataset.ret;
            document.querySelector("h1").textContent = this.textContent;
            //fjern .valgt fra alle
            document.querySelectorAll("#filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
          
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visRetter();
        }
         function filtreringIndhold() {
            filterIndhold = this.dataset.cont;
            document.querySelector("h1").textContent = this.textContent;
             //fjern .valgt fra alle
            document.querySelectorAll("#indhold-filtrering .filter").forEach(elm => {
                elm.classList.remove("valgt");
            });
            //tilføj .valgt til den valgte
            this.classList.add("valgt");
            visRetter();
        }
    </script>

	</section><!-- #primary -->

<?php
get_footer();
