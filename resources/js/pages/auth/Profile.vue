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
/* ==========================================
   PROFESSIONAL MEATHOUSE PROFILE THEME
   Matches final Cart / Checkout theme
   Layout is unchanged
========================================== */
.profile-page {
    --page-bg: #ffffff;
    --surface: #ffffff;
    --surface-soft: #faf8f5;
    --text: #1f1f1f;
    --muted: #666666;
    --muted-soft: #8a8a8a;
    --primary: #b62323;
    --primary-hover: #971d1d;
    --primary-soft: #fff5f3;
    --green: #47632f;
    --gold: #c79a3b;
    --border: #e7e0d6;
    --border-strong: #d7c9b7;
    --danger: #b42318;
    --danger-soft: #fff5f3;
    --shadow: 0 6px 18px rgba(31, 31, 31, .04);
    --shadow-hover: 0 12px 26px rgba(31, 31, 31, .075);

    position: relative;
    padding: 165px 0 80px;
    color: var(--text);
    background: #ffffff;
}

.profile-page::before {
    content: "";
    position: fixed;
    inset: 0;
    pointer-events: none;
    background: #ffffff;
    z-index: -1;
}

.profile-title {
    margin-bottom: 30px;
}

.profile-title span,
.card-heading span {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    color: var(--green);
    font-size: 12px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1.1px;
}

.profile-title span::before,
.card-heading span::before {
    content: "";
    width: 24px;
    height: 3px;
    border-radius: 999px;
    background: var(--gold);
}

.profile-title h1 {
    color: var(--text);
    font-size: 36px;
    font-weight: 850;
    letter-spacing: -.6px;
    margin: 8px 0 5px;
}

.profile-title p {
    color: var(--muted);
    margin: 0;
    font-size: 15px;
}

.profile-summary-card,
.profile-card {
    position: relative;
    overflow: hidden;
    background: #ffffff;
    border: 1px solid var(--border);
    border-radius: 14px;
    padding: 24px;
    box-shadow: var(--shadow);
}

.profile-summary-card:hover,
.profile-card:hover {
    border-color: var(--border-strong);
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
    margin-bottom: 16px;
}

.avatar {
    width: 88px;
    height: 88px;
    border-radius: 50%;
    display: grid;
    place-items: center;
    color: #ffffff;
    font-size: 28px;
    font-weight: 850;
    background: var(--primary);
    box-shadow: 0 10px 22px rgba(182, 35, 35, .18);
}

.profile-summary-card h2 {
    color: var(--text);
    font-size: 22px;
    font-weight: 850;
    margin: 0 0 6px;
}

.profile-summary-card p {
    color: var(--muted);
    margin: 0;
    font-size: 14px;
}

.summary-list {
    display: grid;
    gap: 11px;
    margin: 24px 0;
    text-align: left;
}

.summary-list div {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 13px 14px;
    border-radius: 10px;
    background: #f6f1ea;
    border: 1px solid var(--border);
}

.summary-list span {
    color: var(--muted);
    font-size: 13px;
}

.summary-list strong {
    color: var(--text);
    font-size: 13px;
    font-weight: 850;
}

.profile-card {
    margin-bottom: 20px;
}

.card-heading {
    margin-bottom: 22px;
    border-bottom: 1px solid var(--border);
    padding-bottom: 16px;
}

.card-heading h2 {
    color: var(--text);
    margin: 4px 0 0;
    font-size: 24px;
    font-weight: 850;
    letter-spacing: -.25px;
}

label {
    display: block;
    color: var(--text);
    font-size: 13px;
    font-weight: 800;
    margin-bottom: 7px;
}

input {
    width: 100%;
    border: 1px solid var(--border);
    background: #ffffff;
    color: var(--text);
    border-radius: 10px;
    padding: 12px 13px;
    transition: all .2s ease;
    outline: none;
}

input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(182, 35, 35, .08);
}

input::placeholder {
    color: var(--muted-soft);
}

.invalid {
    border-color: var(--danger) !important;
    box-shadow: 0 0 0 3px rgba(180, 35, 24, .10) !important;
}

small {
    display: block;
    color: var(--danger);
    font-size: 12px;
    font-weight: 750;
    margin-top: 6px;
}

.success-message {
    background: #f4f8ef;
    border: 1px solid rgba(71, 99, 47, .24);
    color: var(--green);
    border-radius: 10px;
    padding: 11px 13px;
    font-weight: 800;
    margin-bottom: 15px;
}

.save-btn,
.logout-btn {
    width: 100%;
    height: 50px;
    border-radius: 10px;
    font-weight: 850;
    letter-spacing: .2px;
    transition: all .2s ease;
}

.save-btn {
    margin-top: 20px;
    border: none;
    background: var(--primary);
    color: #ffffff;
    box-shadow: 0 10px 22px rgba(182, 35, 35, .18);
}

.save-btn:hover:not(:disabled) {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

.save-btn:disabled {
    background: #dadada;
    color: rgba(37, 37, 37, .45);
    box-shadow: none;
    cursor: not-allowed;
}

.logout-btn {
    border: 1px solid var(--border);
    background: #ffffff;
    color: var(--muted);
}

.logout-btn:hover {
    border-color: var(--danger);
    color: var(--danger);
    background: var(--danger-soft);
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
        font-size: 32px;
    }

    .profile-summary-card,
    .profile-card {
        padding: 20px;
    }

    .card-heading h2 {
        font-size: 22px;
    }
}
</style>
