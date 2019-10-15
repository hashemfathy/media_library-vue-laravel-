export const getImages = (state,{images, meta}) => {
  state.images = state.images.concat(images)
  state.meta = meta
}
export const updateImages = (state) => {      
  state.images = []
}
export const updateMeta = (state,{meta}) => {      
  state.meta = meta
}

export const showImage = (state,{image}) => {   
  state.image = image
}

export const uploadedImage = (state,{image}) => {
  state.images = [...state.images,image.media]
}

export const deleteImage = (state,{imageId}) => { 
  const imageIndex = state.images.findIndex(image=>image.data.id === imageId)
  if (imageIndex !== -1) {
    const newImagesArray = [...state.images];
    state.images = newImagesArray.filter(image=>image.data.id !== imageId);
    state.image = null
  }
}

export const updateShowedImage = (state,{imageId,newImage}) => {   
  const imageIndex = state.images.findIndex(image=>image.data.id === imageId)
  if (imageIndex !== -1) {
    const newImagesArray = [...state.images];
    newImagesArray[imageIndex] = newImage;
    state.images = newImagesArray
    state.image = newImage
  }
}

export const updateQueryParams = (state,{query}) => { 
  state.queryParams = query
}