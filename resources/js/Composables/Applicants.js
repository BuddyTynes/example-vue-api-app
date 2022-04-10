import { ref } from 'vue';
import axios from 'axios';

export default function useApplicants() {
    const applicants = ref([]);
    const links = ref({});
    
    const getApplicants = async (page=null) => {
        if (page === null) {
            page = '/api/applicants';
        }

        const response = await axios.get(page);
        links.value = response.data.links;
        applicants.value = response.data.data;
    };

    const addApplicant = async (form) => {
        const response = await axios.post('/api/applicants', form);
    };
    
    const updateApplicant = async (applicant) => {
        const response = await axios.put(`/api/applicants/${applicant.id}`, applicant);
        const index = applicants.value.findIndex((a) => a.id === applicant.id);
        applicants.value[index] = response.data;
    };
    
    const deleteApplicant = async (id) => {
        await axios.delete(`/api/applicants/${id}`);
    };

    const searchApplicant = async (search) => {
        const response = await axios.get(`/search/applicants?q=${search}`);
        applicants.value = response.data;
    };
    
    return {
        links,
        applicants,
        getApplicants,
        addApplicant,
        deleteApplicant,
        updateApplicant,
        searchApplicant,
    };
}