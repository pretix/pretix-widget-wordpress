const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

module.exports = {
	entry: {
		'pretix-tickets-widget': './src/blocks/pretix-tickets-widget/index.js',
		'pretix-tickets-button': './src/blocks/pretix-tickets-button/index.js',
	},
	output: {
		path: path.resolve(__dirname, 'dist'),
		filename: '[name].build.js',
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
				},
			},
			{
				test: /\.s[ac]ss$/i,
				use: [
					MiniCssExtractPlugin.loader,
					'css-loader',
					'sass-loader',
				],
			},
			{
				test: /\.svg$/,
				use: [
					{
						loader: 'file-loader',
						options: {
							name: '[name].[ext]',
							outputPath: 'icons',
							publicPath: '../icons',
						},
					},
				],
			},
		],
	},
	plugins: [
		new MiniCssExtractPlugin({
			filename: '[name].build.css',
		}),
		new CopyWebpackPlugin({
			patterns: [
				{ from: 'src/blocks/*/icon.svg', to: 'icons/[name].[ext]' },
			],
		}),
	],
	devtool: 'source-map',
};