import { ref } from 'vue';
import axios from 'axios';

export default function useApplicants() {
    const applicants = ref([]);
    const links = ref({});
    
    const getApplicants = async () => {
        const response = await axios.get('/api/applicants');

        links.value = response.data.links;
        applicants.value = response.data.data;
    };

    const addApplicant = async (form) => {
        console.log(form);
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
    
    return {
        links,
        applicants,
        getApplicants,
        addApplicant,
        deleteApplicant,
    };
}