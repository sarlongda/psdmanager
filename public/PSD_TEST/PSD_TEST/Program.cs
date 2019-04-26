﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using Aurigma.GraphicsMill;
using Aurigma.GraphicsMill.AdvancedDrawing;
using Aurigma.GraphicsMill.Codecs;
using Aurigma.GraphicsMill.Codecs.Psd;
using Aurigma.GraphicsMill.Templates;
using Aurigma.GraphicsMill.Transforms;

namespace PSD_TEST
{
    using Aurigma.GraphicsMill;
    using Aurigma.GraphicsMill.AdvancedDrawing;
    using Aurigma.GraphicsMill.Codecs;
    using Aurigma.GraphicsMill.Codecs.Psd;
    using Aurigma.GraphicsMill.Templates;
    using Aurigma.GraphicsMill.Transforms;

    internal class RenderTemplatesExample
    {
        private static void Main(string[] args)
        {
            //MergeLayers();
            UpdateText(args[0]);
            //UpdateTextColor();

            //InvertBackground();
            //ReplaceBackground();

            //MergeSeal();
            //UpdateTextAndShapeColor();
        }

        /// <summary>
            /// Merges PSD image to TIFF file
            /// </summary>
        private static void MergeLayers()
        {
            var psdProcessor = new PsdProcessor();

            psdProcessor.Render(@"../../../../_Input/idtestfront.psd", @"../../../../_Output/MergeLayers.tif");
        }

        /// <summary>
            /// Updates text layer of PSD image and saves to PDF file
            /// </summary>
        private static void UpdateText(string str)
        {
            var psdProcessor = new PsdProcessor();

            psdProcessor.StringCallback = (processor, textFrame) =>
            {
                var textString = textFrame.GetFormattedText();

                if (textFrame.Name == "Name")
                    textString = str;

                return textString;
            };

            psdProcessor.Render(@"../../../../_Input/idtestfront.psd", @"../../../../_Output/UpdateText.png");
        }

        /// <summary>
            /// Updates text color of PSD image and saves to PDF file
            /// </summary>
        private static void UpdateTextColor()
        {
            var psdProcessor = new PsdProcessor();

            psdProcessor.TextCallback = (processor, textFrame, textString) =>
            {
                var text = processor.ProcessText(textFrame);
                text.String = textString;

                if (textFrame.Name == "Name")
                    text.Brush = new SolidBrush(RgbColor.Red);

                return text;
            };

            psdProcessor.Render(@"../../../../_Input/idtestfront.psd", @"../../../../_Output/UpdateTextColor.pdf");
        }

        /// <summary>
            /// Inverts background layer of PSD image and saves to PDF file
            /// </summary>
        private static void InvertBackground()
        {
            var psdProcessor = new PsdProcessor();

            psdProcessor.FrameCallback = (processor, frame) =>
            {
                if (frame.Type != FrameType.Raster)
                    return processor.ProcessFrame(frame);

                using (var invert = new Invert())
                {
                    return frame.ToGraphicsContainer(frame + invert, ResizeMode.ImageFill);
                }
            };

            psdProcessor.Render(@"../../../../_Input/idtestfront.psd", @"../../../../_Output/InvertBackground.pdf");
        }

        /// <summary>
            /// Replaces background image of PSD image and saves to PDF file
            /// </summary>
        private static void ReplaceBackground()
        {
            PsdProcessor psdProcessor = new PsdProcessor();

            psdProcessor.FrameCallback = (processor, frame) =>
            {
                if (frame.Type != FrameType.Raster)
                    return processor.ProcessFrame(frame);

                using (var background = ImageReader.Create(@"../../../../_Input/Venice.jpg"))
                {
                    background.CloseOnDispose = false;

                    return frame.ToGraphicsContainer(background, ResizeMode.ImageFill);
                }
            };

            psdProcessor.Render(@"../../../../_Input/idtestfront.psd", @"../../../../_Output/ReplaceBackground.pdf");
        }

        /// <summary>
            ///  Merges PSD image with vector shape layers to PDF file
            /// </summary>
        private static void MergeSeal()
        {
            var psdProcessor = new PsdProcessor();

            psdProcessor.Render(@"../../../../_Input/idtestback.psd", @"../../../../_Output/MergeSeal.pdf");
        }

        /// <summary>
            /// Updates text and shape color of PSD image and saves to PDF file
            /// </summary>
        private static void UpdateTextAndShapeColor()
        {
            var psdProcessor = new PsdProcessor();

            psdProcessor.TextCallback = (processor, textFrame, textString) =>
            {
                var text = processor.ProcessText(textFrame);
                text.String = textString;

                text.Brush = new SolidBrush(RgbColor.DarkRed);

                return text;
            };

            psdProcessor.FrameCallback = (processor, frame) =>
            {
                if (frame.Type != FrameType.Shape)
                    return processor.ProcessFrame(frame);

                var shapeFrame = (PsdShapeFrame)frame;

                var graphicsContainer = new GraphicsContainer(frame.X + frame.Width, frame.Y + frame.Height, frame.DpiX, frame.DpiY);

                using (var graphics = graphicsContainer.GetGraphics())
                {
                    graphics.FillPath(new SolidBrush(RgbColor.DarkGreen), shapeFrame.VectorMask);
                }

                return graphicsContainer;
            };

            psdProcessor.Render(@"../../../../_Input/idtestback.psd", @"../../../../_Output/UpdateTextAndShapeColor.pdf");
        }
    }
}
