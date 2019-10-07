import api from '../api/api.js'

export const getImages = async ({ commit },{queryParams}) => {
    try {
        const response = await api.images.all(queryParams)
        commit('getImages',{
            images:response.data.data,
            meta:response.data.meta
        })
        return response;
    } catch (error) {
        console.log('getImages',error);
    }
};

export const deleteImage = ({ commit },{imageId}) => {
    api.images.delete(imageId).then(() => {
        commit('deleteImage',{imageId})
     })
};

export const updateShowedImage = ({ commit },{imageId,information}) => {
    api.images.update(imageId,information).then((response) => {
        const newImage = response.data.media;
        commit('updateShowedImage',{imageId,newImage})
     })
};
