
import _ from "lodash";
import { useToast } from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
import { menus } from "./menus";
import { mappingFields } from "@/LeadFilters/fields"
import axios from './axios.js';
import LeadFilters from "@/LeadFilters/filters.js";

const $toast = useToast();

export const trans = (string, args) => {
    let value = _.get(window.i18n, string);

    let defaultVal = _.last(_.split(string, "."));
    if (value) {
        _.eachRight(args, (paramVal, paramKey) => {
            value = _.replace(value, `:${paramKey}`, paramVal);
        });
    } else {
        value = defaultVal;
    }
    return value;
};

export const convertJsonToFormData = (data) => {
    const formData = new FormData()
    const entries = Object.entries(data)
    for (const element of entries) {
        const arKey = element[0]
        let arVal = element[1]
        if (typeof arVal === 'boolean') {
            arVal = arVal === true ? 1 : 0
        }
        if (Array.isArray(arVal)) {
            if (arVal[0] instanceof Object) {
                for (let j = 0; j < arVal.length; j++) {
                    if (arVal[j] instanceof Object) {
                        for (const prop in arVal[j]) {
                            if (Object.prototype.hasOwnProperty.call(arVal[j], prop)) {
                                if (!isNaN(Date.parse(arVal[j][prop]))) {
                                    formData.append(
                                        `${arKey}[${j}][${prop}]`,
                                        new Date(arVal[j][prop])
                                    )
                                } else {
                                    formData.append(`${arKey}[${j}][${prop}]`, arVal[j][prop])
                                }
                            }
                        }
                    }
                }
                continue
            } else {
                arVal = JSON.stringify(arVal)
            }
        }

        if (arVal === null) {
            continue
        }
        formData.append(arKey, arVal)
    }
    return formData
};

export const notificationMessage = (type, message) => {
    const toast = $toast[type](message, {
        position: 'top-right',
        duration: 3000,
        dismissible: true
    });
    return toast;
}

export const getMenuBaseOnRole = (role) => {
    return menus[role];
}

export const getFieldsBaseOnRole = (role) => {
    return mappingFields[role]
}

export const addLeadTagFilter = async (name) => {
    try {
        const endPoint = `${import.meta.env.VITE_API_BASE_URL}lead/tags`;
        const filterData = await axios.post(endPoint, { name });
        let status = filterData.data.status;
        if(status){
            return status;
        }
    } catch (error) {
        if(error.response.data.errors.name){
            return error.response.data.message;
        }
    }
}

export const addLeadRatingFilter = async (name) => {
    try {
        const endPoint = `${import.meta.env.VITE_API_BASE_URL}lead/ratings`;
        const filterData = await axios.post(endPoint, { name });
        let status = filterData.data.status;
        if(status){
            return status;
        }
    } catch (error) {
        if(error.response.data.errors.name){
            return error.response.data.message;
        }
    }
}

export const addNotesFilter = async (name) => {
    try {
        const endPoint = `${import.meta.env.VITE_API_BASE_URL}note/strike/first`;
        const filterData = await axios.post(endPoint, { name });
        let status = filterData.data.status;
        if(status){
            return status;
        }
    } catch (error) {
        if(error.response.data.errors.name){
            return error.response.data.message;
        }
    }
}

export const addStatusFilter = async (name) => {
    try {
        const endPoint = `${import.meta.env.VITE_API_BASE_URL}status`;
        const filterData = await axios.post(endPoint, { name });
        let status = filterData.data.status;
        if(status){
            return status;
        }
    } catch (error) {
        if(error.response.data.errors.name){
            return error.response.data.message;
        }
    }
}


export const getFilters = async (path, type) => {
    try {
        const getDefaultFiltersDetail = getDefaultFilters(type);
        const endPoint = `${import.meta.env.VITE_API_BASE_URL}${path}`;
        const filterData = await axios.get(endPoint);
        let status = filterData.data.status;
        if(status){
            let getFilterNames =  filterData.data.data.map((val) => val.name);
            getFilterNames = getDefaultFiltersDetail.concat(getFilterNames);
            return getFilterNames;
        }
    } catch (error) {
        if(error.response.data.errors.name){
            return error.response.data.message;
        }
    }
}

const getDefaultFilters = (type) => {
    return LeadFilters[type];
}