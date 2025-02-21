<template>
    <div class="grid mt-4 mx-0 overflow-hidden">
        <div class="col-12">
            <div v-if="status" class="mb-4">
                <div class="chip green">{{ status }}</div>
            </div>
            <div v-for="(error, field) in errors" :key="field">
                <span class="helper-text red-text">{{ error }}</span>
            </div>
        </div>

        <div :class="loginCardClass">
            <Card>
                <template #content>
                    <div class="image-container">
                        <img src="/public/svg/logoipsum.svg" alt="Icon"/>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <h1 class="text-4xl text-center">{{ $t('auth.Login') }}</h1>
                        </div>
                    </div>

                    <transition name="fade" @before-enter="beforeEnter" @enter="enter" @leave="leave">
                        <!-- Use the child LoginForm here -->
                        <LoginForm
                            v-if="isLoginExpanded"
                            :login-form="loginForm"
                            :can-reset-password="canResetPassword"
                            @submit-login="submitLogin"
                        />
                    </transition>

                    <div v-if="!isLoginExpanded">
                        <Button @click="toggleLoginCard" :label="$t('auth.Got an account?')" class="mt-4" />
                    </div>
                </template>
            </Card>
        </div>

        <div :class="registerCardClass">
            <Card>
                <template #content>
                    <div class="image-container">
                        <img src="/public/svg/logoipsum.svg" alt="Icon"/>
                    </div>

                    <div class="grid">
                        <div class="col-12">
                            <h1 class="text-4xl text-center">{{ $t('auth.Register') }}</h1>
                        </div>
                    </div>

                    <transition name="fade" @before-enter="beforeEnter" @enter="enter" @leave="leave">
                        <!-- Use the child RegisterForm here -->
                        <RegisterForm
                            v-if="isRegisterExpanded"
                            :register-form="registerForm"
                            @submit-register="submitRegister"
                        />
                    </transition>

                    <div v-if="!isRegisterExpanded">
                        <Button @click="toggleRegisterCard" :label="$t('auth.New here?')" class="mt-4" />
                    </div>
                </template>
            </Card>
        </div>
    </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useForm } from '@inertiajs/vue3'

// PrimeVue or your own components
import Card from 'primevue/card'
import Button from '../../Components/Button.vue'

// Child forms
import LoginForm from './LoginForm.vue'
import RegisterForm from './RegisterForm.vue'

/**
 * Setup reactive form data via Inertia's useForm
 */
const loginForm = useForm({
    email: '',
    password: '',
})

const registerForm = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
})

/**
 * Other shared state
 */
const errors = ref({})
const status = ref('')
const canResetPassword = true

const expandedCard = ref('login')

/**
 * Methods to submit the forms
 */
const submitLogin = async () => {
    loginForm.post(route('login'), {
        onError: (err) => {
            errors.value = err
        },
        onSuccess: (page) => {
            status.value = page.props.flash?.message || ''
        },
    })
}

const submitRegister = async () => {
    registerForm.post('/register', {
        onError: (err) => {
            errors.value = err
        },
        onSuccess: (page) => {
            status.value = page.props.flash?.message || ''
        },
    })
}

/**
 * Toggle which card is expanded
 */
const toggleLoginCard = () => {
    expandedCard.value = expandedCard.value === 'login' ? null : 'login'
}
const toggleRegisterCard = () => {
    expandedCard.value = expandedCard.value === 'register' ? null : 'register'
}

/**
 * Dynamically compute card sizes
 */
const loginCardClass = computed(() => ({
    'col-8': expandedCard.value === 'login',
    'col-4': expandedCard.value !== 'login',
    'transition-all': true,
}))
const registerCardClass = computed(() => ({
    'col-8': expandedCard.value === 'register',
    'col-4': expandedCard.value !== 'register',
    'transition-all': true,
}))

const isLoginExpanded = computed(() => expandedCard.value === 'login')
const isRegisterExpanded = computed(() => expandedCard.value === 'register')

/**
 * Transition callbacks
 */
const beforeEnter = (el) => {
    el.style.opacity = 0
}
const enter = (el, done) => {
    el.offsetHeight // force reflow
    el.style.transition = 'opacity 0.5s'
    el.style.opacity = 1
    done()
}
const leave = (el, done) => {
    el.style.transition = 'opacity 0.5s'
    el.style.opacity = 0
    done()
}
</script>

<style scoped>
.transition-all {
    transition: all 0.5s ease-in-out;
}

.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.5s ease-in-out;
}

.fade-enter,
.fade-leave-to {
    opacity: 0;
}
</style>
