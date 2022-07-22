import * as THREE from "https://cdn.skypack.dev/three"

const scene = new THREE.Scene();

const aspectRatio = window.innerWidth / window.innerHeight;

const camera = new THREE.PerspectiveCamera(120, aspectRatio);

console.log("Three.js Initialized")