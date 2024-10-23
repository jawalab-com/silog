<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Button, Card, InputError, InputLabel, TextInput } from '@/Components';

const props = defineProps({
    room_type: Object,
});

// Initialize photos as an array of objects with 'src', 'file', 'isNew', and 'path' properties
const photos = ref(
    (props.room_type?.photos ?? []).map((photoUrl) => ({
        src: photoUrl,
        file: null,       // Existing photos don't have a File object
        isNew: false,     // Indicates it's an existing photo
        path: photoUrl,   // Store the path or identifier for backend reference
    }))
);

const removedPhotos = ref([]); // Keep track of removed existing photos

const form = useForm({
    name: props.room_type?.name ?? '',
    description: props.room_type?.description ?? '',
    base_price: props.room_type?.base_price ?? '',
    max_guests: props.room_type?.max_guests ?? '',
    photos: [],            // Will contain new photos to upload
    removed_photos: [],    // Will contain paths of existing photos to delete
});

const title = (!!props.room_type ? 'Edit' : 'Tambah') + ' Room Type';

const back = () => window.history.back();

const saveAction = () => {
    // Prepare form.photos with new files to upload
    form.photos = photos.value
        .filter(photo => photo.isNew)  // Only new photos
        .map(photo => photo.file);

    // Prepare form.removed_photos with paths of existing photos to remove
    form.removed_photos = removedPhotos.value;

    if (!!props.room_type.id) {
        form.put(route("room-types.update", props.room_type.id), {
            forceFormData: true,
        });
    } else {
        form.post(route("room-types.store"), {
            forceFormData: true,
        });
    }
};

const handleFileChange = (event) => {
    const files = Array.from(event.target.files);

    files.forEach((file) => {
        const reader = new FileReader();
        reader.onload = (e) => {
            photos.value.push({
                src: e.target.result,  // Data URL for preview
                file: file,            // File object for upload
                isNew: true,           // Mark as new photo
                path: null,            // No path for new photos
            });
        };
        reader.readAsDataURL(file);
    });

    // Reset the file input to allow re-selection of the same files
    event.target.value = null;
};

const removePhoto = (index) => {
    const photo = photos.value[index];
    if (!photo.isNew && photo.path) {
        // Existing photo, add its path to removedPhotos for backend processing
        removedPhotos.value.push(photo.path);
    }
    // Remove the photo from the photos array
    photos.value.splice(index, 1);
};
</script>

<template>
    <AppLayout :title="title">
        <form @submit.prevent="saveAction">
            <Card>
                <template #header>
                    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                        {{ title }}
                    </h2>
                </template>

                <div class="grid grid-cols-2 gap-2">
                    <!-- Existing form fields -->
                    <div>
                        <InputLabel for="name" value="Nama Tipe" />
                        <TextInput id="name" v-model="form.name" placeholder="Deluxe, Standard, ..." />
                        <InputError :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="description" value="Deskripsi" />
                        <TextInput id="description" v-model="form.description" />
                        <InputError :message="form.errors.description" />
                    </div>

                    <div>
                        <InputLabel for="base_price" value="Harga Dasar" />
                        <TextInput id="base_price" v-model="form.base_price" type="number" />
                        <InputError :message="form.errors.base_price" />
                    </div>

                    <div>
                        <InputLabel for="max_guests" value="Tamu Maksimum" />
                        <TextInput id="max_guests" v-model="form.max_guests" type="number" />
                        <InputError :message="form.errors.max_guests" />
                    </div>
                </div>

                <!-- Upload multiple photos -->
                <div class="mt-4">
                    <InputLabel for="photos" value="Upload Photos" />
                    <input id="photos" type="file" multiple @change="handleFileChange" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4
                               file:rounded file:border-0 file:text-sm file:font-semibold
                               file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <InputError :message="form.errors.photos" />

                    <!-- Preview photos with remove button -->
                    <div class="grid grid-cols-3 gap-2 mt-4">
                        <div v-for="(photo, index) in photos" :key="index" class="relative border rounded">
                            <img :src="`${photo.src}`" class="w-full h-auto rounded" />
                            <button type="button" @click="removePhoto(index)"
                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 hover:bg-red-600">
                                &times;
                            </button>
                        </div>
                    </div>
                </div>

                <template #footer>
                    <div class="flex justify-end">
                        <Button color="gray" class="mr-2" @click="back">
                            Batal
                        </Button>
                        <Button color="blue" type="submit">
                            Simpan
                        </Button>
                    </div>
                </template>
            </Card>
        </form>
    </AppLayout>
</template>
