import api from '../api/api.js'

export const getImages = ({ commit },{page = 1}) => {
    api.images.all(page).then((res) => {
        commit('getImages',{images:res.data.data})
     })
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
