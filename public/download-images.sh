#!/bin/bash

echo "Downloading essential images..."

curl -L -o public/images/hero-bg.jpg "https://images.unsplash.com/photo-1511632765486-a01980e01a18?ixlib=rb-4.0.3&auto=format&fit=crop&w=1600&q=80"

curl -L -o public/images/kepala-sekolah.jpg "https://images.unsplash.com/photo-1582750433449-648ed127bb54?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&h=400&q=80"

curl -L -o public/images/kegiatan1.jpg "https://images.unsplash.com/photo-1503676260728-1c00da094a0b?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=600&q=80"

curl -L -o public/images/kegiatan2.jpg "https://images.unsplash.com/photo-1512486130939-2c4f79935e4f?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&h=600&q=80"

echo "Download selesai"
