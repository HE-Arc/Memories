<template>
  <Head title="Welcome" />

  <div>
    <div class="container-fluid fixed-top p-4">
      <div class="col-12">
        <div v-if="canLogin" class="d-flex justify-content-end">
          <div>
            <Link
              v-if="$page.props.auth.user"
              href="/memories"
              class="text-muted"
            >
              Memories
            </Link>

            <template v-else>
              <Link :href="route('login')" class="text-muted">
                Log in
              </Link>

              <Link
                v-if="canRegister"
                :href="route('register')"
                class="ms-4 text-muted"
              >
                Register
              </Link>
            </template>
          </div>
        </div>
      </div>
    </div>


    <div class="container-fluid my-5 pt-5 px-5">

      <div class="row justify-content-center px-4">
        <div class="col-md-12 col-lg-9">
            <ApplicationLogo class="logoHome"/>
          <div class="homeContent">
            <h1 class="display-1 text-center">Share your memories.</h1>
            <h2 class="text-center">Memory is a website for saving your memories. You can create a memory, associate pictures, location and write about it  ! Finally, you can share your creations with your friends.</h2>
          </div>

        </div>
      </div>
    </div>
  </div>
  <footer id="sticky-footer" class="fixed-bottom flex-shrink-0 py-4 bg-white text-white-50">
    <div class="container text-center">
      <small class="text-dark">Copyright © 2021-2022 HE-Arc | Developped by David Oktay &amp; Ilyas Boillat</small>
    </div>
  </footer>
</template>

<script>
import { Head, Link } from "@inertiajs/inertia-vue3";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";


export default {
  components: {
    Head,
    Link,
    ApplicationLogo
  },
  props: {
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String
  }
};
</script>
<style>
.logoHome
{
    width: 20em;
    height: 10em;
}
.homeContent
{
    margin-top: 12em;
}
</style>
