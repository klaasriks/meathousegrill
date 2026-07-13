<script setup lang="ts">

</script>

<template>
    <!-- Specials Section -->
    <section id="specials" class="specials section">

        <div class="container section-title" data-aos="fade-up">
            <h2>Top Picks</h2>
            <p>Featured Favourites</p>
        </div>

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row">
                <div class="col-lg-3">
                    <ul class="nav nav-tabs flex-column">
                        <li class="nav-item"><a class="nav-link active show" data-bs-toggle="tab" href="#specials-tab-1">Street &amp; Grill Combo</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-2">Half Chicken Meal</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-3">Spicy Chicken Wrap Combo</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-4">300g Ribs Meal</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#specials-tab-5">Beef Curry Meal</a></li>
                    </ul>
                </div>

                <div class="col-lg-9 mt-4 mt-lg-0">
                    <div class="tab-content">

                        <div class="tab-pane active show" id="specials-tab-1">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Street &amp; Grill Combo - R169</h3>
                                    <p class="fst-italic">A customer favourite that brings together generous portions and bold flame-grilled flavour.</p>
                                    <p>Enjoy the perfect combination of Meathouse Grill favourites in one satisfying meal. Designed for guests who want variety, value, and unforgettable taste, this combo delivers a delicious balance of grilled goodness and hearty satisfaction from the first bite to the last.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="/images/menu_images/street_grill_combo.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="specials-tab-2">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Half Chicken Meal - R90</h3>
                                    <p class="fst-italic">Tender, juicy chicken flame-grilled to perfection and packed with flavour.</p>
                                    <p>Marinated in our signature seasoning and grilled over an open flame, this popular meal delivers the perfect balance of tenderness and smoky taste. Ideal for lunch or dinner, it remains one of the most loved choices on our menu.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="/images/menu_images/half_grilled_chicken.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="specials-tab-3">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Spicy Chicken Wrap Combo - R65</h3>
                                    <p class="fst-italic">Fresh, flavourful and finished with the perfect spicy kick.</p>
                                    <p>Tender grilled chicken, crisp ingredients and our signature sauces are wrapped together in a soft tortilla to create a meal that is both convenient and satisfying. Perfect for guests who enjoy bold flavours on the go.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="/images/menu_images/lip_smacker_spicy_wrap.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="specials-tab-4">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>300g Ribs Meal - R130</h3>
                                    <p class="fst-italic">Succulent ribs generously basted and grilled for a rich smoky flavour.</p>
                                    <p>Prepared with care and finished over the grill, our 300g Ribs Meal delivers tenderness, quality and mouth-watering flavour. Every serving is crafted for meat lovers looking for a truly satisfying dining experience.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="/images/menu_images/beef_steak_300g.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane" id="specials-tab-5">
                            <div class="row">
                                <div class="col-lg-8 details order-2 order-lg-1">
                                    <h3>Beef Curry Meal - R115</h3>
                                    <p class="fst-italic">A hearty homemade favourite prepared with rich spices and tender beef.</p>
                                    <p>Slow-cooked to develop deep flavour and comforting aromas, this meal combines tender beef with a delicious curry sauce for a truly satisfying experience. A perfect choice for guests looking for warmth, flavour and comfort in every bite.</p>
                                </div>
                                <div class="col-lg-4 text-center order-1 order-lg-2">
                                    <img src="/images/menu_images/mutton_curry.jpg" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </section>

    <!-- /Specials Section -->
</template>
<style scoped>


.img-fluid {
    width: 230px;
    height: 230px;
    object-fit: cover;
    border-radius: 50%;
}


</style>
