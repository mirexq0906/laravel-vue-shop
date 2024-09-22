import axios from "axios";
import { useToast } from "primevue/usetoast";

export default () => {
    const toast = useToast();
    const fetchPost = async (url, params = {}) => {
        try {
            const response = await axios.post(url, params, {
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            });
            return response.data;
        } catch (e) {
            let message =
                e?.response?.data?.message ??
                e?.response?.message ??
                "Неизвестная ошибка";
            console.log(e);
            toast.add({
                severity: "error",
                summary: "Ошибка!",
                detail: message,
                life: 3000,
            });
        }
    };

    const fetchGet = async (url, params = {}) => {
        try {
            const response = await axios.get(url, {
                params,
                headers: {
                    Authorization: "Bearer " + localStorage.getItem("token"),
                },
            });
            return response.data;
        } catch (e) {
            let message =
                e?.response?.data?.message ??
                e?.response?.message ??
                "Неизвестная ошибка";
            console.log(e);
            toast.add({
                severity: "error",
                summary: "Ошибка!",
                detail: message,
                life: 3000,
            });
        }
    };

    return {
        fetchGet,
        fetchPost,
    };
};
