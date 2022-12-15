/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./app/Views/**/*.php"],
  theme: {
		extend: {},
		fontFamily: {
			sans: ["Jost", "sans-serif"],
			display: ["Jost", "sans-serif"],
		},
	},
  plugins: [require("daisyui")],
  daisyui: {
		themes: [
			"bumblebee"
		],
	},
}