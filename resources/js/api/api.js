import axios from 'axios'

export default {
    'images' : {
        'all' : queryParams => axios.get('/images',{
            params:queryParams
        }),
        'delete': (imageId) => axios.delete(
            `/delete-media/${imageId}`
        ),
        'update': (imageId,information) => axios.put(
            `/update-media/${imageId}`,{
                information
            }
        )
        
    }
}