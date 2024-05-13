<template>
    <div id="page-wrapper">
        <div class="page-container">
            <side-bar></side-bar>
            <div class="main-content">
                <div class="section__content section__content--p30">
                    <div class="container-fluid">
                        <top-bar></top-bar>
                        <router-view></router-view>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

}
</script>