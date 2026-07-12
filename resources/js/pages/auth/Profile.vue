<script setup lang="ts">
import AppLayout from '@/layouts/restaurantly/AppLayout.vue';
import { computed, ref } from 'vue';
import { router, usePage } from '@inertiajs/vue3';

defineOptions({
    layout: AppLayout,
});

type UserProfile = {
    name?: string;
    email?: string;
    phone_number?: string;
    phone?: string;
};

const page = usePage();

const authUser = computed<UserProfile>(() => {
    return ((page.props as any)?.auth?.user ?? {}) as UserProfile;
});

const profile = ref({
    name: authUser.value.name ?? '',
    email: authUser.value.email ?? '',
    phone_number: authUser.value.phone_number ?? '',
    phone: authUser.value.phone ?? '',
});

const password = ref({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const isSavingProfile = ref(false);
const isSavingPassword = ref(false);
const profileSaved = ref(false);
const passwordSaved = ref(false);
const profileErrors = ref<Record<string, string>>({});
const passwordErrors = ref<Record<string, string>>({});

const initials = computed(() => {
    const name = profile.value.name || 'MG';

    return name
        .split(' ')
        .filter(Boolean)
        .slice(0, 2)
        .map(part => part.charAt(0).toUpperCase())
        .join('') || 'MG';
});

const validateProfile = () => {
    profileErrors.value = {};

    if (!profile.value.name.trim()) {
        profileErrors.value.name = 'Name is required.';
    }

    if (!profile.value.email.trim()) {
        profileErrors.value.email = 'Email address is required.';
    }

    if (profile.value.email && !/^\S+@\S+\.\S+$/.test(profile.value.email)) {
        profileErrors.value.email = 'Please enter a valid email address.';
    }

    if (!profile.value.phone_number.trim()) {
        profileErrors.value.phone_number = 'Phone number address is required.';
    }

    return Object.keys(profileErrors.value).length === 0;
};

const validatePassword = () => {
    passwordErrors.value = {};

    if (!password.value.current_password.trim()) {
        passwordErrors.value.current_password = 'Current password is required.';
    }

    if (!password.value.password.trim()) {
        passwordErrors.value.password = 'New password is required.';
    }

    if (password.value.password && password.value.password.length < 8) {
        passwordErrors.value.password = 'Password must be at least 8 characters.';
    }

    if (password.value.password !== password.value.password_confirmation) {
        passwordErrors.value.password_confirmation = 'Password confirmation does not match.';
    }

    return Object.keys(passwordErrors.value).length === 0;
};

const saveProfile = () => {
    if (!validateProfile()) return;

    isSavingProfile.value = true;
    profileSaved.value = false;

    router.patch('/profile', profile.value, {
        preserveScroll: true,
        onSuccess: () => {
            profileSaved.value = true;
        },
        onError: errors => {
            profileErrors.value = errors as Record<string, string>;
        },
        onFinish: () => {
            isSavingProfile.value = false;
        },
    });
};

const savePassword = () => {
    if (!validatePassword()) return;

    isSavingPassword.value = true;
    passwordSaved.value = false;

    router.put('/password', password.value, {
        preserveScroll: true,
        onSuccess: () => {
            passwordSaved.value = true;
            password.value.current_password = '';
            password.value.password = '';
            password.value.password_confirmation = '';
        },
        onError: errors => {
            passwordErrors.value = errors as Record<string, string>;
        },
        onFinish: () => {
            isSavingPassword.value = false;
        },
    });
};

const logout = () => {
    router.post('/logout');
};
</script>

<template>
    <div class="container profile-page">
        <div class="profile-title">
            <span>My Account</span>
            <h1>Profile Settings</h1>
            <p>Manage your Meathouse Grill account details, contact information, and password.</p>
        </div>

        <div class="row g-4">
            <div class="col-lg-4">
                <div class="profile-summary-card">
                    <div class="avatar-wrap">
                        <div class="avatar">
                            {{ initials }}
                        </div>
                    </div>

                    <h2>{{ profile.name || 'Meathouse Customer' }}</h2>
                    <p>{{ profile.email || 'No email available' }}</p>

                    <div class="summary-list">
                        <div>
                            <span>Account status</span>
                            <strong>Active</strong>
                        </div>

                        <div>
                            <span>Preferred order type</span>
                            <strong>Collection</strong>
                        </div>

                        <div>
                            <span>Saved cart</span>
                            <strong>Available</strong>
                        </div>
                    </div>

                    <button class="logout-btn" type="button" @click="logout">
                        Log Out
                    </button>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="profile-card">
                    <div class="card-heading">
                        <span>Profile Details</span>
                        <h2>Personal Information</h2>
                    </div>

                    <div class="success-message" v-if="profileSaved">
                        Profile details updated successfully.
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name">Full Name</label>
                            <input
                                id="name"
                                type="text"
                                v-model="profile.name"
                                :class="{ invalid: profileErrors.name }"
                                placeholder="Full name"
                            />
                            <small v-if="profileErrors.name">{{ profileErrors.name }}</small>
                        </div>

                        <div class="col-md-6">
                            <label for="email">Email Address</label>
                            <input
                                id="email"
                                type="email"
                                v-model="profile.email"
                                :class="{ invalid: profileErrors.email }"
                                placeholder="email@example.com"
                            />
                            <small v-if="profileErrors.email">{{ profileErrors.email }}</small>
                        </div>

                        <div class="col-md-6">
                            <label for="phone">Phone Number</label>
                            <input
                                id="phone_number"
                                type="tel"
                                v-model="profile.phone_number"
                                :class="{ invalid: profileErrors.phone_number }"
                                placeholder="e.g. 071 000 0000"
                            />
                            <small v-if="profileErrors.phone_number">{{ profileErrors.phone_number }}</small>
                        </div>
                    </div>

                    <button class="save-btn" type="button" :disabled="isSavingProfile" @click="saveProfile">
                        {{ isSavingProfile ? 'Saving...' : 'Save Profile' }}
                    </button>
                </div>

                <div class="profile-card">
                    <div class="card-heading">
                        <span>Security</span>
                        <h2>Change Password</h2>
                    </div>

                    <div class="success-message" v-if="passwordSaved">
                        Password updated successfully.
                    </div>

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label for="current_password">Current Password</label>
                            <input
                                id="current_password"
                                type="password"
                                v-model="password.current_password"
                                :class="{ invalid: passwordErrors.current_password }"
                                placeholder="Current password"
                            />
                            <small v-if="passwordErrors.current_password">{{ passwordErrors.current_password }}</small>
                        </div>

                        <div class="col-md-6">
                            <label for="password">New Password</label>
                            <input
                                id="password"
                                type="password"
                                v-model="password.password"
                                :class="{ invalid: passwordErrors.password }"
                                placeholder="New password"
                            />
                            <small v-if="passwordErrors.password">{{ passwordErrors.password }}</small>
                        </div>

                        <div class="col-md-6">
                            <label for="password_confirmation">Confirm Password</label>
                            <input
                                id="password_confirmation"
                                type="password"
                                v-model="password.password_confirmation"
                                :class="{ invalid: passwordErrors.password_confirmation }"
                                placeholder="Confirm password"
                            />
                            <small v-if="passwordErrors.password_confirmation">{{ passwordErrors.password_confirmation }}</small>
                        </div>
                    </div>

                    <button class="save-btn" type="button" :disabled="isSavingPassword" @click="savePassword">
                        {{ isSavingPassword ? 'Updating...' : 'Update Password' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.profile-page {
    --surface: rgba(255, 255, 255, .92);
    --surface-solid: #ffffff;
    --surface-soft: #fff0e5;
    --text: #261b16;
    --muted: #6b5b52;
    --muted-soft: #9a8171;
    --primary: #f04a2a;
    --primary-hover: #df3517;
    --primary-soft: #fff0eb;
    --orange: #ff8a2a;
    --yellow: #ffcf4d;
    --green: #7fa14b;
    --border: #f0dfcc;
    --danger: #ef3f37;
    --danger-soft: #fff0ef;
    --shadow: 0 12px 30px rgba(83, 45, 23, .08);
    --shadow-hover: 0 20px 45px rgba(83, 45, 23, .14);

    position: relative;
    padding: 170px 0 80px;
    color: var(--text);
}

.profile-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background:
        radial-gradient(circle at 10% 14%, rgba(255, 207, 77, .24), transparent 28%),
        radial-gradient(circle at 88% 24%, rgba(240, 74, 42, .16), transparent 26%),
        linear-gradient(180deg, #fff9f2 0%, #fff3e6 100%);
    z-index: -1;
}

.profile-title {
    margin-bottom: 34px;
}

.profile-title span,
.card-heading span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--primary);
    font-size: 12px;
    font-weight: 950;
    text-transform: uppercase;
    letter-spacing: 1.4px;
}

.profile-title span::before,
.card-heading span::before {
    content: "";
    width: 26px;
    height: 4px;
    border-radius: 999px;
    background: linear-gradient(90deg, var(--primary), var(--orange));
}

.profile-title h1 {
    color: var(--text);
    font-size: 44px;
    font-weight: 950;
    letter-spacing: -.9px;
    margin: 8px 0;
}

.profile-title p {
    color: var(--muted);
    margin: 0;
    font-size: 16px;
}

.profile-summary-card,
.profile-card {
    position: relative;
    overflow: hidden;
    background: var(--surface);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(240, 223, 204, .95);
    border-radius: 28px;
    padding: 28px;
    box-shadow: var(--shadow);
}

.profile-summary-card::before,
.profile-card::before {
    content: "";
    position: absolute;
    inset: 0 0 auto 0;
    height: 6px;
    background: linear-gradient(90deg, var(--primary), var(--orange), var(--yellow));
}

.profile-summary-card:hover,
.profile-card:hover {
    box-shadow: var(--shadow-hover);
}

.profile-summary-card {
    position: sticky;
    top: 120px;
    text-align: center;
}

.avatar-wrap {
    display: flex;
    justify-content: center;
    margin-bottom: 18px;
}

.avatar {
    width: 96px;
    height: 96px;
    border-radius: 28px;
    display: grid;
    place-items: center;
    color: #ffffff;
    font-size: 32px;
    font-weight: 950;
    background: linear-gradient(135deg, var(--primary), var(--orange));
    box-shadow: 0 16px 34px rgba(240, 74, 42, .24);
}

.profile-summary-card h2 {
    color: var(--text);
    font-size: 25px;
    font-weight: 950;
    margin: 0 0 6px;
}

.profile-summary-card p {
    color: var(--muted);
    margin: 0;
}

.summary-list {
    display: grid;
    gap: 12px;
    margin: 28px 0;
    text-align: left;
}

.summary-list div {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 14px;
    border-radius: 16px;
    background: rgba(255, 255, 255, .75);
    border: 1px solid var(--border);
}

.summary-list span {
    color: var(--muted);
    font-size: 13px;
}

.summary-list strong {
    color: var(--text);
    font-size: 13px;
    font-weight: 950;
}

.profile-card {
    margin-bottom: 24px;
}

.card-heading {
    margin-bottom: 24px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 18px;
}

.card-heading h2 {
    color: var(--text);
    margin: 4px 0 0;
    font-size: 26px;
    font-weight: 950;
    letter-spacing: -.4px;
}

label {
    display: block;
    color: var(--text);
    font-size: 14px;
    font-weight: 900;
    margin-bottom: 8px;
}

input {
    width: 100%;
    border: 1px solid var(--border);
    background: var(--surface-solid);
    color: var(--text);
    border-radius: 15px;
    padding: 14px 15px;
    transition: all .25s ease;
    outline: none;
}

input:focus {
    border-color: rgba(240, 74, 42, .55);
    box-shadow: 0 0 0 4px rgba(240, 74, 42, .10);
}

input::placeholder {
    color: var(--muted-soft);
}

.invalid {
    border-color: var(--danger) !important;
    box-shadow: 0 0 0 4px rgba(239, 63, 55, .10) !important;
}

small {
    display: block;
    color: var(--danger);
    font-size: 12px;
    font-weight: 800;
    margin-top: 7px;
}

.success-message {
    background: #f7ffee;
    border: 1px solid rgba(127, 161, 75, .45);
    color: var(--green);
    border-radius: 14px;
    padding: 12px 14px;
    font-weight: 900;
    margin-bottom: 18px;
}

.save-btn,
.logout-btn {
    width: 100%;
    height: 54px;
    border-radius: 16px;
    font-weight: 950;
    letter-spacing: .3px;
    transition: all .25s ease;
}

.save-btn {
    margin-top: 24px;
    border: none;
    background: linear-gradient(135deg, var(--primary), var(--orange));
    color: #ffffff;
    box-shadow: 0 16px 34px rgba(240, 74, 42, .24);
}

.save-btn:hover:not(:disabled) {
    background: linear-gradient(135deg, var(--primary-hover), var(--primary));
    transform: translateY(-2px);
}

.save-btn:disabled {
    background: #d7cec6;
    color: rgba(37, 37, 37, .45);
    box-shadow: none;
    cursor: not-allowed;
}

.logout-btn {
    border: 1px solid var(--border);
    background: transparent;
    color: var(--muted);
}

.logout-btn:hover {
    border-color: var(--primary);
    color: var(--primary);
    background: var(--primary-soft);
}

@media (max-width: 991px) {
    .profile-page {
        padding-top: 145px;
    }

    .profile-summary-card {
        position: relative;
        top: 0;
    }
}

@media (max-width: 768px) {
    .profile-title h1 {
        font-size: 34px;
    }

    .profile-summary-card,
    .profile-card {
        padding: 22px;
    }
}
</style>
