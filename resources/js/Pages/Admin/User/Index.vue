<script setup>
import {Head, useForm} from '@inertiajs/vue3';
import AdminLayout from "@/Layouts/Admin/Layout.vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import {ref} from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

defineProps({
    users: Array,
});

const confirmingUserDeletion = ref(false);
const confirmingUserRestore = ref(false);
const userIsSoftDeleted = ref(false);

const form = useForm({
    userId: null,
    forceDelete: false,
});

const confirmUserDeletion = (user) => {
    confirmingUserDeletion.value = true;
    form.userId = user.id;
    userIsSoftDeleted.value = user.deleted_at;
};

const confirmUserRestore = (user) => {
    confirmingUserRestore.value = true;
    form.userId = user.id;
};

const deleteUser = (forceDelete = false) => {
    form.forceDelete = forceDelete;
    form.delete(route('admin.users'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const restoreUser = () => {
    form.post(route('admin.users.restore'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    confirmingUserRestore.value = false;

    form.reset();
};

</script>

<template>
    <AdminLayout>
        <Head title="Users" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="grid grid-cols-12 gap-4 p-4 uppercase bg-gray-200 dark:bg-gray-600">
                            <div class="col-span-2">Name</div>
                            <div class="col-span-4">Email</div>
                            <div>Deleted</div>
                            <div>at</div>
                            <div class="col-span-2">Roles</div>
                            <div class="col-span-2 text-right">Actions</div>
                        </div>
                        <div v-for="user in users"
                             v-bind:class="{ 'text-gray-600 dark:text-gray-400': user.deleted_at }"
                             class="grid grid-cols-12 gap-4 p-4 border-b border-gray-600"
                        >
                            <div class="col-span-2">{{ user.name }}</div>
                            <div class="col-span-4">{{ user.email }}</div>
                            <div class="italic">
                                {{ user.deleted_at ? 'deleted' : '' }}
                            </div>
                            <div class="italic">
                                {{ user.deleted_at ? new Date(user.deleted_at).toLocaleDateString('en') : '' }}
                            </div>
                            <div class="col-span-2">
                                <span v-for="role in user.roles" class="p-1 rounded-md bg-gray-800 text-gray-300 dark:text-gray-800 dark:bg-gray-300">
                                    {{ role.name }}
                                </span>
                            </div>
                            <div class="col-span-2 flex justify-end">
                                <span v-if="user.deleted_at" class="mx-1">
                                    <SecondaryButton @click="confirmUserRestore(user)">
                                        <svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path fill="#333" d="M89.1 202.6c7.7-21.8 20.2-42.3 37.8-59.8c62.5-62.5 163.8-62.5 226.3 0L370.3 160H320c-17.7 0-32 14.3-32 32s14.3 32 32 32H447.5c0 0 0 0 0 0h.4c17.7 0 32-14.3 32-32V64c0-17.7-14.3-32-32-32s-32 14.3-32 32v51.2L398.4 97.6c-87.5-87.5-229.3-87.5-316.8 0C57.2 122 39.6 150.7 28.8 181.4c-5.9 16.7 2.9 34.9 19.5 40.8s34.9-2.9 40.8-19.5zM23 289.3c-5 1.5-9.8 4.2-13.7 8.2c-4 4-6.7 8.8-8.1 14c-.3 1.2-.6 2.5-.8 3.8c-.3 1.7-.4 3.4-.4 5.1V448c0 17.7 14.3 32 32 32s32-14.3 32-32V396.9l17.6 17.5 0 0c87.5 87.4 229.3 87.4 316.7 0c24.4-24.4 42.1-53.1 52.9-83.7c5.9-16.7-2.9-34.9-19.5-40.8s-34.9 2.9-40.8 19.5c-7.7 21.8-20.2 42.3-37.8 59.8c-62.5 62.5-163.8 62.5-226.3 0l-.1-.1L109.6 352H160c17.7 0 32-14.3 32-32s-14.3-32-32-32H32.4c-1.6 0-3.2 .1-4.8 .3s-3.1 .5-4.6 1z"/>
                                        </svg>
                                    </SecondaryButton>
                                </span>
                                <span v-if="!user.is_admin" class="mx-1">
                                    <DangerButton @click="confirmUserDeletion(user)">
                                        <svg class="w-3" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                            <path fill="#FFFFFF" d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                        </svg>
                                    </DangerButton>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <Modal :show="confirmingUserDeletion" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Are you sure you want to delete this account?
                    </h2>

                    <p v-if="!userIsSoftDeleted" class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        You can delete forever this account or simply deactivate it.
                    </p>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="deleteUser(true)"
                        >
                            Delete Forever
                        </SecondaryButton>

                        <DangerButton
                            v-if="!userIsSoftDeleted"
                            class="ml-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="deleteUser()"
                        >
                            Deactivate Account
                        </DangerButton>
                    </div>
                </div>
            </Modal>
            <Modal :show="confirmingUserRestore" @close="closeModal">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                        Are you sure you want to restore this account?
                    </h2>

                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        It will be possible for the user to log back in.
                    </p>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="restoreUser()"
                        >
                            Restore account
                        </SecondaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AdminLayout>
</template>
