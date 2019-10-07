import axios from 'axios'

export default {
    'images' : {
        'all' : (page = 1) => axios.get('/api/images',{
            params:{
                page
            }
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