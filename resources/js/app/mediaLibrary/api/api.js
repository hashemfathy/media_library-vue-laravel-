import axios from 'axios'

export default {
    'images' : {
        'all' : queryParams => axios.get('/media-library/images',{
            params:queryParams
        }),
        'delete': (imageId) => axios.delete(
            `/media-library/delete-media/${imageId}`
        ),
        'update': (imageId,information) => axios.put(
            `/media-library/update-media/${imageId}`,{
                information
            }
        )
        
    }
}