<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>

    <Head title="Log in" />

    <!-- <AuthenticationCard>
        <template #logo>
            <AuthenticationCardLogo />
        </template>

<div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
    {{ status }}
</div>

<form @submit.prevent="submit">
    <div>
        <InputLabel for="email" value="Email" />
        <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full" required autofocus
            autocomplete="username" />
        <InputError class="mt-2" :message="form.errors.email" />
    </div>

    <div class="mt-4">
        <InputLabel for="password" value="Password" />
        <TextInput id="password" v-model="form.password" type="password" class="mt-1 block w-full" required
            autocomplete="current-password" />
        <InputError class="mt-2" :message="form.errors.password" />
    </div>

    <div class="flex items-center justify-between mt-4">
        <label class="flex items-center">
            <Checkbox v-model:checked="form.remember" name="remember" />
            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
        </label>

        <Link v-if="canResetPassword" :href="route('password.request')"
            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
        Forgot your password?
        </Link>
    </div>

    <div class="flex items-center justify-between mt-4">
        <div>
            <span class=" text-sm text-gray-600 dark:text-gray-400">Don't have an account?</span>
            <Link v-if="canResetPassword" :href="route('register')"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
            Register
            </Link>
        </div>

        <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
            Log in
        </PrimaryButton>
    </div>

    <div class="flex items-center py-4">
        <div class="flex-grow border-t border-gray-400 dark:border-gray-600"></div>
        <span class="mx-4 text-gray-600 dark:text-gray-400">or continue with</span>
        <div class="flex-grow border-t border-gray-400 dark:border-gray-600"></div>
    </div>

    <div class="flex items-center justify-between">
        <a class="w-full inline-flex items-center justify-center px-4 py-1 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
            :href="route('auth.redirect', { 'provider': 'google' })">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" class="mr-2">
                <g id="google">
                    <g id="google-vector" fill-rule="evenodd" clip-rule="evenodd">
                        <path id="Shape" fill="#4285F4"
                            d="M20.64 12.205q-.002-.957-.164-1.84H12v3.48h4.844a4.14 4.14 0 0 1-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615">
                        </path>
                        <path id="Shape_2" fill="#34A853"
                            d="M12 21c2.43 0 4.468-.806 5.957-2.18L15.05 16.56c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H3.958v2.332A9 9 0 0 0 12.001 21">
                        </path>
                        <path id="Shape_3" fill="#FBBC05"
                            d="M6.964 13.712a5.4 5.4 0 0 1-.282-1.71c0-.593.102-1.17.282-1.71V7.96H3.957A9 9 0 0 0 3 12.002c0 1.452.348 2.827.957 4.042z">
                        </path>
                        <path id="Shape_4" fill="#EA4335"
                            d="M12 6.58c1.322 0 2.508.455 3.441 1.346l2.582-2.58C16.463 3.892 14.427 3 12 3a9 9 0 0 0-8.043 4.958l3.007 2.332c.708-2.127 2.692-3.71 5.036-3.71">
                        </path>
                    </g>
                </g>
            </svg>
            Google
        </a>
    </div>

    <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-2">
        <span class=" text-sm text-gray-800 dark:text-gray-200">By signing up, you are agree to the <a target="_blank"
                :href="route('terms.show')"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Terms
                of Service</a> and <a target="_blank" :href="route('policy.show')"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Privacy
                Policy</a></span>
    </div>
</form>
</AuthenticationCard> -->


    <section class="bg-gray-50 dark:bg-gray-900 flex flex-col lg:flex-row min-h-screen">
        <div class="flex-1 justify-around items-center text-white lg:w-1/2">
            <div
                class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0 bg-gray-200 dark:bg-gray-800">
                <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900 dark:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-8 mr-2">
                        <path fill="#E34F26" d="M71,460 L30,0 481,0 440,460 255,512"></path>
                        <path fill="#EF652A" d="M256,472 L405,431 440,37 256,37"></path>
                        <path fill="#EBEBEB"
                            d="M256,208 L181,208 176,150 256,150 256,94 255,94 114,94 115,109 129,265 256,265zM256,355 L255,355 192,338 188,293 158,293 132,293 139,382 255,414 256,414z">
                        </path>
                        <path fill="#FFF"
                            d="M255,208 L255,265 325,265 318,338 255,355 255,414 371,382 372,372 385,223 387,208 371,208zM255,94 L255,129 255,150 255,150 392,150 392,150 392,150 393,138 396,109 397,94z">
                        </path>
                    </svg>
                    Demo App
                </a>
                <div
                    class="w-full bg-white rounded-lg shadow border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-900 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                            {{ status }}
                        </div>

                        <form @submit.prevent="submit">
                            <h3 class="mb-4 font-semibold">Sign in to your account</h3>
                            <div class="flex items-center justify-between">
                                <a class="w-full inline-flex items-center justify-center px-4 py-1 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-sm text-white dark:text-gray-800 hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150"
                                    :href="route('auth.redirect', { 'provider': 'google' })">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                        viewBox="0 0 24 24" class="mr-2">
                                        <g id="google">
                                            <g id="google-vector" fill-rule="evenodd" clip-rule="evenodd">
                                                <path id="Shape" fill="#4285F4"
                                                    d="M20.64 12.205q-.002-.957-.164-1.84H12v3.48h4.844a4.14 4.14 0 0 1-1.796 2.717v2.258h2.908c1.702-1.567 2.684-3.874 2.684-6.615">
                                                </path>
                                                <path id="Shape_2" fill="#34A853"
                                                    d="M12 21c2.43 0 4.468-.806 5.957-2.18L15.05 16.56c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H3.958v2.332A9 9 0 0 0 12.001 21">
                                                </path>
                                                <path id="Shape_3" fill="#FBBC05"
                                                    d="M6.964 13.712a5.4 5.4 0 0 1-.282-1.71c0-.593.102-1.17.282-1.71V7.96H3.957A9 9 0 0 0 3 12.002c0 1.452.348 2.827.957 4.042z">
                                                </path>
                                                <path id="Shape_4" fill="#EA4335"
                                                    d="M12 6.58c1.322 0 2.508.455 3.441 1.346l2.582-2.58C16.463 3.892 14.427 3 12 3a9 9 0 0 0-8.043 4.958l3.007 2.332c.708-2.127 2.692-3.71 5.036-3.71">
                                                </path>
                                            </g>
                                        </g>
                                    </svg>
                                    Continue with Google
                                </a>
                            </div>

                            <div class="flex items-center py-4">
                                <div class="flex-grow border-t border-gray-400 dark:border-gray-600"></div>
                                <span class="mx-4 text-gray-600 dark:text-gray-400">or</span>
                                <div class="flex-grow border-t border-gray-400 dark:border-gray-600"></div>
                            </div>
                            <div>
                                <InputLabel for="email" value="Email" />
                                <TextInput id="email" v-model="form.email" type="email" class="mt-1 block w-full"
                                    required autofocus autocomplete="username" />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mt-4">
                                <InputLabel for="password" value="Password" />
                                <TextInput id="password" v-model="form.password" type="password"
                                    class="mt-1 block w-full" required autocomplete="current-password" />
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <label class="flex items-center">
                                    <Checkbox v-model:checked="form.remember" name="remember" />
                                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                                </label>

                                <Link v-if="canResetPassword" :href="route('password.request')"
                                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                Forgot your password?
                                </Link>
                            </div>

                            <div class="flex items-center justify-between mt-4">
                                <div>
                                    <span class=" text-sm text-gray-600 dark:text-gray-400">Don't have an
                                        account?</span>
                                    <Link v-if="canResetPassword" :href="route('register')"
                                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                                    Register
                                    </Link>
                                </div>

                                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }"
                                    :disabled="form.processing">
                                    Sign in
                                </PrimaryButton>
                            </div>

                            <div v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature" class="mt-2">
                                <span class=" text-sm text-gray-800 dark:text-gray-200">By continuing, you are agree to
                                    the
                                    <a target="_blank" :href="route('terms.show')"
                                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Terms
                                        of Service</a> and <a target="_blank" :href="route('policy.show')"
                                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">Privacy
                                        Policy</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="hidden lg:flex flex-1 items-center justify-center">
            <div class="w-2/3 flex justify-center">
                <img src="https://www.svgheart.com/wp-content/uploads/2022/07/135_Fishing-min.png" alt="login-welcome"
                    class="w-50 h-auto rounded-lg" />
            </div>
        </div>
    </section>
</template>
