import axios from 'axios'

export default {
    'images' : {
        'all' : queryParams => axios.get('/api/images',{
            params:queryParams
        }),
        'delete': (imageId) => axios.delete(
            `/api/delete-media/${imageId}`
        ),
        'update': (imageId,information) => axios.put(
            `/api/update-media/${imageId}`,{
                information
            }
        )
        
    }
}