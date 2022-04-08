import { ref } from 'vue';
import axios from 'axios';

export default function useApplicants() {
    const applicants = ref([]);
    
    const getApplicants = async () => {
        const response = await axios.get('/api/applicants');
        applicants.value = response.data.data;
    };
    
    const addApplicant = async (applicant) => {
        const response = await axios.post('/api/applicants', applicant);
        applicants.value.push(response.data);
    };
    
    const updateApplicant = async (applicant) => {
        const response = await axios.put(`/api/applicants/${applicant.id}`, applicant);
        const index = applicants.value.findIndex((a) => a.id === applicant.id);
        applicants.value[index] = response.data;
    };
    
    const deleteApplicant = async (applicant) => {
        await axios.delete(`/api/applicants/${applicant.id}`);
        applicants.value = applicants.value.filter((a) => a.id !== applicant.id);
    };
    
    return {
        applicants,
        getApplicants,
        addApplicant,
        updateApplicant,
        deleteApplicant,
    };
}