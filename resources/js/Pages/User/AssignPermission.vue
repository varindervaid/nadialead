<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <BreadcrumbDefault pageTitle="Assign Permission" />


            <div class="mt-6"
                v-for="(model, index) in models"
                :key="item"
            >
            <form>
                <DefaultCard :cardTitle="model+': Assign Permissions to ' + model + ' Roles'">
                    <div class="max-w-full overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead>
                                <tr class="bg-gray-2 text-left dark:bg-meta-4">
                                    <th width="50" class="py-4 px-4 font-medium bg-graydark text-white uppercase text-left">
                                        Roles
                                    </th>
                                    <th
                                        v-for="(item, index) in permissions"
                                        :key="item"
                                        class="uppercase py-4 px-4 font-medium text-black dark:text-white xl:pl-11"
                                    >
                                        {{ item.name.replace(/_/g, ' ') }}
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(role, index) in user_roles" :key="item">
                                    <td class="py-5 px-4 bg-graydark uppercase text-left text-sm text-white" >
                                        {{ role.name }}
                                    </td>
                                    <td
                                        v-for="(item, index) in permissions"
                                        :key="item"
                                        class="py-5 px-4 pl-9 xl:pl-11" >
                                        <h5 class="font-medium text-black dark:text-white">
                                            <div class="flex items-center mb-4">
                                                <input
                                                    :id="model+'_'+role.id+item.id"
                                                    type="checkbox"
                                                    value=""
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                                />
                                                <label
                                                    :for="model+'_'+role.id+item.id"
                                                    class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300 capitalize">{{ item.name.replace(/_/g, ' ') }}</label>
                                            </div>
                                        </h5>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </DefaultCard>

                <div class="mt-6 flex justify-end">
                    <PrimaryButton class="">Save</PrimaryButton>
                </div>
                </form>
            </div>

    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch, onMounted, onUnmounted, provide } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import InputError from "@/components/InputError.vue";
import Modal from "@/components/Modal.vue";
import InputLabel from "@/components/InputLabel.vue";
import PrimaryButton from "@/components/PrimaryButton.vue";
import TextInput from "@/components/TextInput.vue";
import SelectInput from "@/components/SelectInput.vue";
import DefaultCard from "@/components/Forms/DefaultCard.vue";
import BreadcrumbDefault from "@/components/Breadcrumbs/BreadcrumbDefault.vue";
import axios from "axios";
import { Head, Link, useForm, usePage, router } from "@inertiajs/vue3";

const permissions = usePage().props.permissions;
const user_roles = usePage().props.roles;
const models = usePage().props.models;

const form = useForm({});
</script>
